<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;

use Illuminate\Support\Collection;

class ArdorAccountCurrencies extends ArdorBasic {

    public array $accountCurrencies   = [];
    public int $requestProcessingTime = 0;


    public function __construct(object $data){
        parent::__construct($data);
    }

}