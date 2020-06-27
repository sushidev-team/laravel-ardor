<?php

namespace AMBERSIVE\Ardor\Jobs;

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
        $contracts = collect(config('ardor.contracts'))->map(function($contract){
            return "\\${contract}";
        });

        dd($contracts);
    }
}
