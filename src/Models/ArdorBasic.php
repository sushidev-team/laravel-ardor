<?php 

namespace AMBERSIVE\Ardor\Models;

use Carbon\Carbon;

use AMBERSIVE\Ardor\Classes\ArdorHelper;

class ArdorBasic {

    public function __construct(object $data){

        $values = get_object_vars($data);
        
        foreach($values as $key => $value) {
            if (isset($this->$key)){
                $this->$key = $value;
            }            
        }

    }
    
    /**
     * Tranform the ardor time to a valid carbon date format
     *
     * @param  mixed $seconds
     * @return Carbon
     */
    protected function transformToGenesisTime($seconds): Carbon {
        return Carbon::createFromDate(2018, 1, 1)->addSeconds($seconds);
    }

    public function transformToVoucher(String $methodName):String {

        $data = json_decode(json_encode($this), true);

        $transactionJSON = data_get($data,'transactionJSON');

        if (isset($transactionJSON['recipient']) === false && isset($transactionJSON['recipientRS']) === true) {
           $account = ArdorHelper::getAccount($transactionJSON['recipientRS']);
           $transactionJSON['recipient'] = $account->account;
        }

        if (isset($transactionJSON['amountNQT']) === false){
            $transactionJSON['amountNQT'] = "0";
        }

        $json = [
            "transactionJSON" => $transactionJSON,
            "unsignedTransactionBytes" => data_get($data,'unsignedTransactionBytes'),
            "signature" => data_get($data, 'transactionJSON.signatureHash'),
            //"publicKey" => "e7de39ea6ee815ec1a1969442a69970629aa09a067c8f5321c77460fc1373b0e",
            "requestType" => $methodName
        ];

        dd(json_encode($json));

        dd($this);

    }

}