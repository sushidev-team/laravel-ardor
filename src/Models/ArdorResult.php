<?php 

namespace AMBERSIVE\Ardor\Models;

class ArdorResult {

    public int $statusCode = 0;
    public $data;

    public function __construct(int $statusCode = 200, $data = null){
        $this->statusCode = $statusCode; 
        $this->data = $data;
    }

}