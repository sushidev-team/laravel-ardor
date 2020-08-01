<?php 

namespace AMBERSIVE\Ardor\Classes;

use AMBERSIVE\Ardor\Classes\ArdorBaseHandler;

use Carbon\Carbon;

use AMBERSIVE\Ardor\Models\ArdorNode;
use AMBERSIVE\Ardor\Models\ArdorAccount;
use AMBERSIVE\Ardor\Models\ArdorAccountCurrencies;
use AMBERSIVE\Ardor\Models\ArdorBalance;

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
    public function getAccountCurrencies(String $account, array $more = []): ArdorAccountCurrencies {

        $body = $this->mergeBody([
            'account' => $account        
        ], $more, null, false);

        $response = $this->send("getAccountCurrencies", $body, false, 'form_params');

        return new ArdorAccountCurrencies($response);

    }
    
    /**
     * Get the currency balance of an account
     *
     * @param  mixed $account
     * @param  mixed $chain
     * @param  mixed $more
     * @return ArdorBalance
     */
    public function getBalance(String $account, int $chain = 1, array $more = []): ArdorBalance {

        $body = $this->mergeBody([
            'account' => $account ,
            'chain'   => $chain       
        ], $more, null, false);

        $response = $this->send("getBalance", $body, false, 'form_params');

        return new ArdorBalance($response);

    }
    
    /**
     * Get multiple balances for an account
     *
     * @param  mixed $account
     * @param  mixed $chains
     * @param  mixed $more
     * @return array
     */
    public function getBalances(String $account, array $chains = [1], array $more = []): array {

        $data = [];
        foreach (array_unique($chains) as $chain) {
            $data[] = $this->getBalance($account, $chain, $more);
        }
        return $data;

    }


}