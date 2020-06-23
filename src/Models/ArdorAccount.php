<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;

use Illuminate\Support\Collection;

class ArdorAccount extends ArdorBasic {

    public int $forgedBalanceFQT = 0;

    public String $account = "";
    public String $accountRS = "";
    public String $publicKey = "";
    public String $guaranteedBalanceFQT = "";
    public int $effectiveBalanceFXT = 0;
    
    public int $requestProcessingTime = 0;


    public function __construct(object $data){
        parent::__construct($data);
    }

}