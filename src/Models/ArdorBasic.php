<?php 

namespace AMBERSIVE\Ardor\Models;

use Carbon\Carbon;

class ArdorBasic {

    public function __construct(object $data){

        $values = get_object_vars($data);
        
        foreach($values as $key => $value) {
            if (isset($this->$key)){
                $this->$key = $value;
            }            
        }

    }
    
    /**
     * Tranform the ardor time to a valid carbon date format
     *
     * @param  mixed $seconds
     * @return Carbon
     */
    protected function transformToGenesisTime($seconds): Carbon {
        return Carbon::createFromDate(2018, 1, 1)->addSeconds($seconds);
    }

}