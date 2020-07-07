<?php 

namespace AMBERSIVE\Ardor\Abstracts;

use AMBERSIVE\Ardor\Interfaces\ArdorContractInterface;

use AMBERSIVE\Ardor\Models\ArdorNode;
use AMBERSIVE\Ardor\Models\ArdorPrunableMessage;

use AMBERSIVE\Ardor\Classes\ArdorBundlerHandler;

abstract class ContractDefault implements ArdorContractInterface {

    public array $config = [];
    public ArdorNode $ardorNode;
    public ArdorBundler $ardorBundler;

    public function __construct(array $config = []){
        
        $this->config = $config;
        $this->ardorNode = new ArdorNode(data_get($config, 'nodeUrl'));
        $this->ardorBundler = new ArdorBundlerHandler($this->ardorNode);
        
    }
    
    /**
     * Returns the name of the contract or null if it cannot be defined
     *
     * @return String
     */
    public function getName():String {
        return isset($this->name) ? $this->name : null;
    }

    public function run(ArdorPrunableMessage $message):bool {
        return false;
    }

}