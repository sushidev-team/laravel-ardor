<?php 

namespace AMBERSIVE\Ardor\Classes;

use AMBERSIVE\Ardor\Models\ArdorNode;
use AMBERSIVE\Ardor\Models\ArdorBase;

use Carbon\Carbon;

class ArdorServer extends ArdorBase {

    public function __construct(ArdorNode $node = null){
        parent::__construct($node);
    }

    public function getTime(): Carbon {
        
    }

}