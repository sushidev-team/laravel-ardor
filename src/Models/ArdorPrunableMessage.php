<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;
use AMBERSIVE\Ardor\Models\ArdorTransactionJson;

use Illuminate\Support\Collection;

use Carbon\Carbon;

class ArdorPrunableMessage extends ArdorBasic {

    public String $sender = "";
    public String $senderRS = "";
    public String $recipient = "";
    public String $recipientRS = "";
    public String $transactionFullHash = "";
    public int $blockTimestamp = 0;
    public bool $messageIsText = false;
    public String $message = "";
    public bool $isText = false;
    public int $transactionTimestamp = 0;
    
    public function __construct(object $data){
        parent::__construct($data);
    }

    public function decryptMessage(String $message = "") {
        
        // TODO: Create the decrypting part in this message
        return $message;

    }
    
    /**
     * Returns the message body as array (should only be used if the message body can tranformed)
     *
     * @return array
     */
    public function messageToArray():array {
        return json_decode($this->decryptMessage($this->message), true);
    }

}