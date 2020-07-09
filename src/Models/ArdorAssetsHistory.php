<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;
use AMBERSIVE\Ardor\Models\ArdorAssetsHistoryEntry;

use Illuminate\Support\Collection;

class ArdorAssetsHistory extends ArdorBasic {

    public Collection $assets;

    public function __construct(object $data){
        parent::__construct($data);

        $this->assetHistory = collect($data->assetHistory)->transform(function($entry){
            return new ArdorAssetsHistoryEntry($entry);
        });

    }

}