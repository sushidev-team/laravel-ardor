<?php 

namespace AMBERSIVE\Ardor\Models;

class ArdorBasic {

    public function __construct(object $data){

        $values = get_object_vars($data);
        
        foreach($values as $key => $value) {
            if (isset($this->$key)){
                $this->$key = $value;
            }            
        }

    }

}