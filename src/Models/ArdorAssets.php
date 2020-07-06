<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;
use AMBERSIVE\Ardor\Models\ArdorAsset;

use Illuminate\Support\Collection;

class ArdorAssets extends ArdorBasic {

    public Collection $assets;

    public function __construct(object $data){
        parent::__construct($data);

        $this->assets = collect($data->assets)->transform(function($message){
            return new ArdorAsset($message);
        });

    }

}