<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;
use AMBERSIVE\Ardor\Models\ArdorTransactionJson;

use Illuminate\Support\Collection;

class ArdorDecryptedMessage extends ArdorBasic {

    public String $decryptedMessage = "";
    public int $requestProcessingTime = 0;
    
    public function __construct(object $data){
        parent::__construct($data);

    }

}