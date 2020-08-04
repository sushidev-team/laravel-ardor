<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;
use AMBERSIVE\Ardor\Models\ArdorAccountAsset;

use Illuminate\Support\Collection;

class ArdorAccountAssets extends ArdorBasic {

    public Collection $accountAssets;

    public function __construct(object $data){
        parent::__construct($data);

        $this->accountAssets = collect($data->accountAssets)->transform(function($asset){
            return new ArdorAccountAsset($asset);
        });
    }

}