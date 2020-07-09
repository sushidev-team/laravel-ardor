<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;

use Illuminate\Support\Collection;

class ArdorAssetsHistoryEntry extends ArdorBasic {

    public String $quantityQNT = "";
    public int $chain = 0;
    
    public String $account = "";
    public String $accountRS = "";

    public String $asset = "";
    public String $assetHistoryFullHash = "";

    public int $height = 0;
    public int $timestamp = 0;

    public function __construct(object $data){
        parent::__construct($data);
    }

}