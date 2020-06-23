<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;
use AMBERSIVE\Ardor\Models\ArdorPrunableMessage;

use Illuminate\Support\Collection;

class ArdorPrunableMessages extends ArdorBasic {

    public ?Collection $messages;

    public function __construct(object $data){

        parent::__construct($data);

        $this->messages = collect($data->prunableMessages)->transform(function($message){
            return new ArdorPrunableMessage($message);
        });

    }

}