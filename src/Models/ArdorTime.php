<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;

use Carbon\Carbon;

use Illuminate\Support\Collection;

class ArdorTime extends ArdorBasic {

    public int $unixtime = 0;
    public int $time = 0;
    public Carbon $carbon;

    public function __construct(object $data){
        parent::__construct($data);
        $this->carbon =  Carbon::createFromTimestamp(isset($data->unixtime) ? $data->unixtime : time()); 
    }

}