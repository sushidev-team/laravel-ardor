<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;
use AMBERSIVE\Ardor\Models\ArdorBlock;
use AMBERSIVE\Ardor\Models\ArdorTransactionSubType;

use Illuminate\Support\Collection;

class ArdorServerPlugins extends ArdorBasic {

    public array $plugins = [];
    public int $requestProcessingTime = 0;

    public function __construct(object $data){
        parent::__construct($data);
    }

}