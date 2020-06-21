<?php 

namespace AMBERSIVE\Ardor\Classes;

use AMBERSIVE\Ardor\Classes\ArdorBase;

use Carbon\Carbon;

use AMBERSIVE\Ardor\Models\ArdorNode;
use AMBERSIVE\Ardor\Models\ArdorTransaction;

class ArdorMessenger extends ArdorBase {

    public function __construct(ArdorNode $node = null, \GuzzleHttp\Client $client = null){
        parent::__construct($node, $client);
    }
    
    /**
     * Send a message via ardor block chain
     *
     * @param  mixed $wallet
     * @param  mixed $message
     * @param  mixed $prunable
     * @param  mixed $more
     * @return void
     */
    public function sendMessage(String $wallet, String $message, bool $prunable = true, array $more = []){

        $body = array_merge($more, [
            'chain' => 2,
            'recipient' => $wallet,
            'message' => $message,
            'messageIsPrunable' => $prunable,
            'secretPhrase' => config('ardor.secret', 'orange welcome begun powerful lonely government cast figure add quit wife loser')
        ]);

        $response = $this->send("sendMessage", $body, false, 'form_params');
        return new ArdorTransaction($response);

    }

}