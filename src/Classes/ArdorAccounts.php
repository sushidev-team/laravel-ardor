<?php 

namespace AMBERSIVE\Ardor\Classes;

use AMBERSIVE\Ardor\Classes\ArdorBase;

use Carbon\Carbon;

use AMBERSIVE\Ardor\Models\ArdorNode;
use AMBERSIVE\Ardor\Models\ArdorAccount;

class ArdorAccounts extends ArdorBase {

    public function __construct(ArdorNode $node = null, \GuzzleHttp\Client $client = null){
        parent::__construct($node, $client);
    }

    public function getAccount(String $account, array $more = []):ArdorAccount {

        $body = $this->mergeBody([
            'account' => $account        
        ], $more, null, false);

        $response = $this->send("getAccount", $body, false, 'form_params');

        return new ArdorAccount($response);

    }

}