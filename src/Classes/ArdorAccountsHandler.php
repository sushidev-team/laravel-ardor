<?php 

namespace AMBERSIVE\Ardor\Classes;

use AMBERSIVE\Ardor\Classes\ArdorBaseHandler;

use Carbon\Carbon;

use AMBERSIVE\Ardor\Models\ArdorNode;
use AMBERSIVE\Ardor\Models\ArdorAccount;
use AMBERSIVE\Ardor\Models\ArdorAccountCurrencies;

class ArdorAccountsHandler extends ArdorBaseHandler  {

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
    
    /**
     * Get all currencies for an acount
     *
     * @param  mixed $account
     * @param  mixed $more
     * @return void
     */
    public function getAccountCurrencies(String $account, array $more = []) {

        $body = $this->mergeBody([
            'account' => $account        
        ], $more, null, false);

        $response = $this->send("getAccountCurrencies", $body, false, 'form_params');

        return new ArdorAccountCurrencies($response);

    }


}