<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;

use Illuminate\Support\Collection;

class ArdorAccountAsset extends ArdorBasic {

    public int $quantityQNT = 0;
    public int $unconfirmedQuantityQNT = 0;
    public String $asset = "";

    public function __construct(object $data){
        parent::__construct($data);
    }

    public function resolve() {

        // TODO: resolve the asset by using the id

    }

}