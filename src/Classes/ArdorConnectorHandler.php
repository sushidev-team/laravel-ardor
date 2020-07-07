<?php 

namespace AMBERSIVE\Ardor\Classes;

use AMBERSIVE\Ardor\Classes\ArdorBaseHandler;

use Carbon\Carbon;

use AMBERSIVE\Ardor\Models\ArdorNode;

class ArdorConnector extends ArdorBaseHandler  {

    public function __construct(ArdorNode $node = null, \GuzzleHttp\Client $client = null){
        parent::__construct($node, $client);
    }



}