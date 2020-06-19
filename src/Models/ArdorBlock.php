<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;

use Illuminate\Support\Collection;

class ArdorBlock extends ArdorBasic {

    public function __construct(object $data){
        parent::__construct($data);
    }

}