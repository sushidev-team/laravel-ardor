<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;

use Illuminate\Support\Collection;

class ArdorFee extends ArdorBasic {

    public int $minimumFeeFQT = 0;
    public int $feeNQT = 0;
    public int $requestProcessingTime = 0;

    public function __construct(object $data){
        parent::__construct($data);
    }

}