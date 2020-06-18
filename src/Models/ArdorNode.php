<?php 

namespace AMBERSIVE\Ardor\Models;

use Carbon\Carbon;

use AMBERSIVE\Ardor\Models\ArdorResult;

class ArdorNode {

    public String $url;

    public function __construct(String $url = null){
        $this->url = $url != null ?  $url : config('ardor.node'); 
    }

    public function getTime() {

    }

}