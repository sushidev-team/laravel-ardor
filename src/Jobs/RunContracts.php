<?php

namespace AMBERSIVE\Ardor\Jobs;

use Cache;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use AMBERSIVE\Ardor\Classes\ArdorNode;
use AMBERSIVE\Ardor\Classes\ArdorBlockchain;
use AMBERSIVE\Ardor\Models\ArdorTransactionJson;

class RunContracts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ArdorBlockchain $ardorBlockchain;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ArdorNode $node = null)
    {
        $this->ardorBlockchain = new ArdorBlockchain($node);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $coount = 0;

        $contracts = collect(config('ardor.contracts'))->map(function($contract){
            return "\\${contract}";
        });

        $unconfirmedTransactions = $this->ardorBlockchain->getUnconfirmedTransactions(2);
        $unconfirmedTransactionsHashed = $unconfirmedTransactions->transactions->pluck("fullHash")->toArray();

        if ($unconfirmedTransactions->transactions->count() === 0) {
            return;
        }

        $unconfirmedTransactions->transactions = $unconfirmedTransactions->transactions->filter(function($transaction){
            if (Cache::store(config('ardor.cache_driver'))->get("ARDOR_CONTRACTS_$transaction->fullHash") === null){
                return $transaction;
            }
        });

        $countRecieved = $unconfirmedTransactions->transactions->count();

        Log::debug("[ARDOR CONTRACTS]: ${countRecieved} Transaction/s will be checked.");

        $unconfirmedTransactions->transactions->each(function(ArdorTransactionJson $transaction) use ($contracts, &$count){

            dd($transaction);

            // Cache the transaction so it will not processed a second time
            Cache::store(config('ardor.cache_driver'))->put("ARDOR_CONTRACTS_$transaction->fullHash", true, 960);

            $contracts->each(function($contractClass) use ($transaction, &$count) {



            });

        });

    }
}
