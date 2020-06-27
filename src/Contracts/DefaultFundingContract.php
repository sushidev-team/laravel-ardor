<?php

namespace AMBERSIVE\Ardor\Contracts;

use AMBERSIVE\Ardor\Interfaces\ArdorContractInterface;

class DefaultFundingContract implements ArdorContractInterface {

    public array $config = [];
    public ArdorNode $ardorNode;
    public ArdorBundler $ardorBundler;

    public function __construct(array $config = []){
        
        $this->config = $config;
        $this->ardorNode = new ArdorNode(data_get($config, 'nodeUrl'));
        $this->ardorBundler = new ArdorBundler($this->ardorNode);
        
    }

}