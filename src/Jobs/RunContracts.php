<?php

namespace AMBERSIVE\Ardor\Jobs;

use Cache;
use Log;

use Carbon\Carbon;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use AMBERSIVE\Ardor\Classes\ArdorNode;
use AMBERSIVE\Ardor\Classes\ArdorBlockchain;
use AMBERSIVE\Ardor\Classes\ArdorHelper;
use AMBERSIVE\Ardor\Classes\ArdorMessenger;
use AMBERSIVE\Ardor\Models\ArdorPrunableMessage;
use AMBERSIVE\Ardor\Models\ArdorTransactionJson;

class RunContracts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ArdorBlockchain $ardorBlockchain;
    protected ArdorMessenger $ardorMessenger;
    protected ArdorHelper $ardorHelper;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ArdorNode $node = null)
    {
        $this->ardorBlockchain = new ArdorBlockchain($node);
        $this->ardorMessenger = new ArdorMessenger($node);
        $this->ardorHelper = new ArdorHelper($node);
    }   

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $count = 0;

        $contracts = collect(config('ardor.contracts'))->map(function($contract){
            return "\\${contract}";
        });

        $now = $this->ardorHelper->getEpochTime(strtotime(Carbon::now())) - (1000*60);

        $prunableMessages = $this->ardorMessenger->disableCache()->getAllPrunableMessages(2, ['lastIndex' => 1000]);

        $prunableMessagesHashed = $prunableMessages->messages->pluck("transactionFullHash")->toArray();

        if ($prunableMessages->messages->count() === 0) {
            return;
        }

        $countBeforeFiltered = $prunableMessages->messages->count();

        Log::debug("[ARDOR CONTRACTS]: ${countBeforeFiltered} Message/s recieved.");

        $countRecieved = $prunableMessages->messages->count();

        Log::debug("[ARDOR CONTRACTS]: ${countRecieved} Messages/s will be checked.");

        $prunableMessages->messages->each(function(ArdorPrunableMessage $message) use ($contracts, &$count){

            $messageJson    = json_decode($message->message);
            $contractName   = optional($messageJson)->contract;
            $contractParams = optional($messageJson)->params;

            if ($contractName === null) {
                return;
            }

            $contractsToExecuted = $contracts->filter(function($contract) use ($contractName){
                
                $contractClassInstance = new $contract();

                if ($contractClassInstance->getName() === $contractName) {
                    return $contract;
                }

            });

            if ($contractsToExecuted->count() === 0) {
                return;
            }

            $countExecuted = 0;

            $contractsToExecuted->each(function($contractClass) use ($message, $contractParams, &$countExecuted) {
                $id      = sha1($contractClass);
                $cacheId = "ARDOR_CONTRACTS_$message->transactionFullHash"."_${id}";
                $countExecuted   = $this->executeContract($message, $contractClass, $contractParams, $countExecuted, $cacheId);
            });
            
            if ($countExecuted > 0) {
                $count++;
            }

        });

        Log::debug("[ARDOR CONTRACTS]: Contract execution was finished in ${count} / ${countRecieved} cases.");


    }
    
    /**
     * Execute a single contract
     *
     * @param  mixed $message
     * @param  mixed $contractClass
     * @param  mixed $contractParams
     * @param  mixed $count
     * @param  mixed $cacheId
     * @return void
     */
    protected function executeContract(ArdorPrunableMessage $message, String $contractClass, object $contractParams, int $count = 0, String $cacheId) {
        
        try {
            if (Cache::store(config('ardor.cache_driver'))->get($cacheId) !== null){
                Log::debug("[ARDOR CONTRACTS]: Already proccessed: ${cacheId}");
                return $count;
            }

            $contractClassInstance = new $contractClass(array_merge([], ['params' => ($contractParams !== null ? $contractParams : [])]));
            $sucsess = $contractClassInstance->run($message);

            if ($sucsess === true) {
                // Increase the amount of proccessed transactions
                if (Cache::store(config('ardor.cache_driver'))->get($cacheId) === null){
                    Cache::store(config('ardor.cache_driver'))->put($cacheId, true, $this->getCacheTime());
                }
                $count++;
            }

        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $ex) {

            Log::error($ex->getMessage());

        }

        return $count;
    }
    
    /**
     * Returns the caching time for a successful message
     *
     * @return int
     */
    protected function getCacheTime():int {
        return 60 * 24 * 60;
    }

}
