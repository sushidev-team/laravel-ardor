<?php 

namespace AMBERSIVE\Ardor\Interfaces;

use AMBERSIVE\Ardor\Models\ArdorTransactionJson;

interface ArdorBundlerInterface {

    public function __construct(array $config = []);
    public function run(ArdorTransactionJson $transaction):bool;

}
