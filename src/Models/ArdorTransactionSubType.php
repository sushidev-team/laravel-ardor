<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;

use Illuminate\Support\Collection;

class ArdorTransactionSubType extends ArdorBasic {

    public bool $isPhasable = false;
    public bool $isPhasingSafe = false;
    public bool $isGlobael = false;
    
    public int $type = 0;
    public int $subtype = 0;

    public String $name = "";
    public bool $mustHaveRecipient = false;
    public bool $canHaveRecipient = false;


    public function __construct(object $data){
        parent::__construct($data);
    }

}