<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;
use AMBERSIVE\Ardor\Models\ArdorBlock;
use AMBERSIVE\Ardor\Models\ArdorTransactionSubType;

use Illuminate\Support\Collection;

class ArdorServerConstants extends ArdorBasic {

    public int $maxNumberOfFxtTransactions = 0;
    public ?ArdorBlock $lastKnownBlock;

    public function __construct(object $data){
        parent::__construct($data);

        $this->lastKnownBlock = isset($data->lastKnownBlock) ? new ArdorBlock($data->lastKnownBlock) : null;

        $this->transactionSubTypes = isset($data->transactionSubTypes) ? collect(get_object_vars($data->transactionSubTypes))->transform(function($subType, $key) {
            $subType->name = $key;
            return new ArdorTransactionSubType($subType);
        }) : collect([]);
    }

}