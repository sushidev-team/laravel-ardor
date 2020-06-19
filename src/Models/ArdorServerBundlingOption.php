<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;
use AMBERSIVE\Ardor\Models\ArdorServerBundlingOption;

use Illuminate\Support\Collection;

class ArdorServerBundlingOption extends ArdorBasic {

    public String $name = "";
    public ?String $description;

    public function __construct(object $data){
        parent::__construct($data);
    }

}