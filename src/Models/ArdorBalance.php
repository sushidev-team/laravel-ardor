<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;

use Illuminate\Support\Collection;

class ArdorBalance extends ArdorBasic {

    public int $unconfirmedBalanceNQT = 0;
    public int $balanceNQT = 0;

    public function __construct(object $data){
        parent::__construct($data);
    }

}