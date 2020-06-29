<?php 

namespace AMBERSIVE\Ardor\Interfaces;

use AMBERSIVE\Ardor\Models\ArdorPrunableMessage;

interface ArdorContractInterface {

    public function __construct(array $config = []);

    public function getName():String;

    public function run(ArdorPrunableMessage $message):bool;

}
