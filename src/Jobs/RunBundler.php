<?php

namespace AMBERSIVE\Ardor\Jobs;

use Log;
use Cache;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use AMBERSIVE\Ardor\Classes\ArdorBlockchainHandler;
use AMBERSIVE\Ardor\Models\ArdorTransactionJson;
use AMBERSIVE\Ardor\Models\ArdorNode;

use Illuminate\Support\Collection;

class RunBundler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public ArdorBlockchainHandler $ardorBlockchain;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ArdorNode $node = null)
    {
        $this->ardorBlockchain = new ArdorBlockchainHandler($node);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $count = 0;
        $countRecieved = 0;

        $bundlers = collect(config('ardor.bundlers'))->map(function($bundler){
            return "\\${bundler}";
        });

        $unconfirmedTransactions = $this->ardorBlockchain->getUnconfirmedTransactions(2);
        $unconfirmedTransactionsHashed = $unconfirmedTransactions->transactions->pluck("fullHash")->toArray();

        $unconfirmedTransactions->transactions = $unconfirmedTransactions->transactions->filter(function($transaction){
             if (Cache::store(config('ardor.cache_driver'))->get("ARDOR_BUNDLER_$transaction->fullHash") === null){
                 return $transaction;
             }
        });       

        $countRecieved = $unconfirmedTransactions->transactions->count();

        Log::debug("[ARDOR BUNDLER]: ${countRecieved} Transaction/s will be checked.");

        $unconfirmedTransactions->transactions->each(function(ArdorTransactionJson $transaction) use ($bundlers, &$count){

            $bundled = false;

            Cache::store(config('ardor.cache_driver'))->put("ARDOR_BUNDLER_$transaction->fullHash", true, 960);

            $bundlers->each(function($bundlerClass) use ($transaction, &$bundled,&$count) {

                if ($bundled === true) {
                    return;
                }

                $config = config("ardor.bundlerSettings.${bundlerClass}", []);

                try {

                    $bundler = new $bundlerClass($config);
                    $bundled = $bundler->run($transaction);

                    if ($bundled) {
                        Log::debug("[ARDOR BUNDLER]: Transaction has been bundled ($transaction->fullHash) by ${bundlerClass}.");
                        $count++;
                    }

                } catch(\Symfony\Component\HttpKernel\Exception\HttpException $ex){
                    $message = $ex->getMessage();
                    Log::debug("[ARDOR BUNDLER]: Transaction has not been bundled ($transaction->fullHash): ${message}.");
                }

            });

        });

        Log::debug("[ARDOR BUNDLER]: ${count} Transaction/s got bundled by this application.");

    }
}
