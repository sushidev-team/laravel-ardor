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
use AMBERSIVE\Ardor\Classes\ArdorMessenger;
use AMBERSIVE\Ardor\Models\ArdorPrunableMessage;
use AMBERSIVE\Ardor\Models\ArdorTransactionJson;

class RunContracts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ArdorBlockchain $ardorBlockchain;
    protected ArdorMessenger $ardorMessenger;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ArdorNode $node = null)
    {
        $this->ardorBlockchain = new ArdorBlockchain($node);
        $this->ardorMessenger = new ArdorMessenger($node);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $coount = 0;
        $timestampSince = Carbon::createFromDate(2018, 1, 1)->diffInSeconds(now());

        $contracts = collect(config('ardor.contracts'))->map(function($contract){
            return "\\${contract}";
        });

        $prunableMessages = $this->ardorMessenger->disableCache()->getAllPrunableMessages(2, ['timestamp' => $timestampSince]);
        $prunableMessagesHashed = $prunableMessages->messages->pluck("transactionFullHash")->toArray();
        
        if ($prunableMessages->messages->count() === 0) {
            return;
        }

        $countBeforeFiltered = $prunableMessages->messages->count();

        Log::debug("[ARDOR CONTRACTS]: ${countBeforeFiltered} Message/s recieved.");

        $prunableMessages->messages = $prunableMessages->messages->filter(function($message){
            if (Cache::store(config('ardor.cache_driver'))->get("ARDOR_CONTRACTS_$message->transactionFullHash") === null){
                return $message;
            }
        });

        $countRecieved = $prunableMessages->messages->count();

        Log::debug("[ARDOR CONTRACTS]: ${countRecieved} Messages/s will be checked.");

        $prunableMessages->messages->each(function(ArdorPrunableMessage $message) use ($contracts, &$count){

            $count = 0;

            // Cache the transaction so it will not processed a second time
            Cache::store(config('ardor.cache_driver'))->put("ARDOR_CONTRACTS_$message->transactionFullHash", true, 960);

            $messageJson = json_decode($message->message);
            $contractName = optional($messageJson)->contract;
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

            Log::debug("[ARDOR CONTRACTS]: All contracts with the following trigger \"${contractName}\" will executed.");

            $contractsToExecuted->each(function($contractClass) use ($message, $contractParams, &$count) {

                try {

                    $contractClassInstance = new $contractClass(array_merge([], ['params' => ($contractParams !== null ? $contractParams : [])]));
                    $sucsess = $contractClassInstance->run($message);

                    if ($sucsess === true) {
                        $count++;

                        if (Cache::store(config('ardor.cache_driver'))->get("ARDOR_CONTRACTS_$message->transactionFullHash") === null){
                            Cache::store(config('ardor.cache_driver'))->put("ARDOR_CONTRACTS_$message->transactionFullHash", true, 960);
                        }
                    }

                } catch (\Symfony\Component\HttpKernel\Exception\HttpException $ex) {

                    if (Cache::store(config('ardor.cache_driver'))->get("ARDOR_CONTRACTS_$message->transactionFullHash") === null){
                        Cache::store(config('ardor.cache_driver'))->put("ARDOR_CONTRACTS_$message->transactionFullHash", true, 960);
                        Cache::store(config('ardor.cache_driver'))->put("ARDOR_CONTRACTS_$message->transactionFullHash", true, 960);

                    }

                }

            });

            $countAll = $contractsToExecuted->count();
            Log::debug("[ARDOR CONTRACTS]: Contract execution was finished in ${count} of ${countAll} cases.");

        });

    }
}
