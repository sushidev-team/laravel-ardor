<?php

namespace AMBERSIVE\Ardor\Bundlers;

use AMBERSIVE\Ardor\Interfaces\ArdorBundlerInterface;


use AMBERSIVE\Ardor\Classes\ArdorBundler;
use AMBERSIVE\Ardor\Models\ArdorNode;
use AMBERSIVE\Ardor\Models\ArdorTransactionJson;

class DefaultTransactionBundler implements ArdorBundlerInterface {

    public array $config = [];
    public ArdorNode $ardorNode;
    public ArdorBundler $ardorBundler;

    public function __construct(array $config = []){
        
        $this->config = $config;
        $this->ardorNode = new ArdorNode(data_get($config, 'nodeUrl', null));
        $this->ardorBundler = new ArdorBundler($this->ardorNode);
        
    }
    
    /**
     * Main entry point for the bundler
     *
     * @param  mixed $transaction
     * @return bool
     */
    public function run(ArdorTransactionJson $transaction):bool {

        if (in_array($transaction->senderRS, data_get($this->config, 'accounts', []))){
            return $this->ardorBundler->bundleTransactions($transaction->fullHash, $transaction->chain);
        }

        return false;

    }

}