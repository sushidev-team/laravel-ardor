<?php 

namespace AMBERSIVE\Ardor\Interfaces;

use AMBERSIVE\Ardor\Models\ArdorTransactionJson;

interface ArdorContractInterface {

    public function __construct(array $config = []);

    public function getName():String;
    public function setName(String $name):String;

    public function run(ArdorTransactionJson $transaction):bool;

}
