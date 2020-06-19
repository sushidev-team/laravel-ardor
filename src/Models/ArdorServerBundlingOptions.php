<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;
use AMBERSIVE\Ardor\Models\ArdorServerBundlingOption;

use Illuminate\Support\Collection;

class ArdorServerBundlingOptions extends ArdorBasic {

    public Collection $availableFilters;
    public array $availableFeeCalculators = [];

    public function __construct(object $data){
        parent::__construct($data);

        $this->availableFilters = isset($data->availableFilters) ? collect($data->availableFilters)->transform(function($filter){
            return new ArdorServerBundlingOption($filter);
        }) : collect([]);


    }

}