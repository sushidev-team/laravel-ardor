<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;
use AMBERSIVE\Ardor\Models\ArdorTransactionJson;

use Illuminate\Support\Collection;

class ArdorMessage extends ArdorBasic {

    public bool $messageIsPrunable = false;
    public String $message = "";
    public String $decryptedMessage = "";
    public String $decryptedMessageToSelf = "";
    public bool $encrypted = false;

    public int $requestProccessingTime = 0;

    public function __construct(object $data){
        parent::__construct($data);

        if (isset($data->decryptedMessage)){
            $this->message = $this->decryptedMessage;
            $this->encrypted = true;
        }
    }

}