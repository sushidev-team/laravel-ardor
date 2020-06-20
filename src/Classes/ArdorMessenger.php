<?php 

namespace AMBERSIVE\Ardor\Classes;

use AMBERSIVE\Ardor\Classes\ArdorBase;

use Carbon\Carbon;

use AMBERSIVE\Ardor\Models\ArdorNode;

class ArdorMessenger extends ArdorBase {

    public function __construct(ArdorNode $node = null, \GuzzleHttp\Client $client = null){
        parent::__construct($node, $client);
    }

    public function sendMessage(String $wallet, String $message, bool $prunable = true){

        $response = $this->send("sendMessage", [
            'chain' => 2,
            'recipient' => $wallet,
            'secretPhrase' => config('ardor.secret', 'orange welcome begun powerful lonely government cast figure add quit wife loser')
        ], false, 'form_params');

        dd($response);

    }

}