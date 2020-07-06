<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;
use AMBERSIVE\Ardor\Models\ArdorAsset;

use Illuminate\Support\Collection;

class ArdorAsset extends ArdorBasic {

    public int $quantityQNT = 0;

    public String $name = "";
    public String $desription = "";
    public String $asset = "";

    public String $account = "";
    public String $accountRS = "";
    public int $decimals = 0;

    public int $numberOfAccounts = 0;
    public int $numberOfTransfers = 0;

    public bool $hasPhasingAssetControl = false;

    public function __construct(object $data){
        parent::__construct($data);
    }

}