<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;

use Illuminate\Support\Collection;

class ArdorTransactionBytes extends ArdorBasic {

    public String $unsignedTransactionBytes = "";
    public int $requestProcessingTime = 0;
     public String $transactionBytes = "";

    public function __construct(object $data){
        parent::__construct($data);
    }

}