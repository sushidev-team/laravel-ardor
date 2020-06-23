<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;
use AMBERSIVE\Ardor\Models\ArdorTransactionJson;

use Illuminate\Support\Collection;

class ArdorTransactionCollection extends ArdorBasic {

    public Collection $transactions;

    public function __construct(object $data){
        parent::__construct($data);

        $transformData = [];

        if (isset($data->unconfirmedTransactions)) {
            $transformData = $data->unconfirmedTransactions;
        }

        $this->transactions = collect($transformData)->transform(function($item){
            return new ArdorTransactionJson($item);
        });      

        //$this->transactionJSON = isset($data->transactionJSON) ? new ArdorTransactionJson($data->transactionJSON) : new ArdorTransactionJson((object) []);
    }

}