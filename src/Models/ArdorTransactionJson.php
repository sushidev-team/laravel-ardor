<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;

use Carbon\Carbon;

class ArdorTransactionJson extends ArdorBasic {

    public String $senderPublicKey = "";
    public int $chain = 0;    
    public int $feeNQT = 0;
    public int $type = 0;
    public int $version = 0;

    public String $fullHash = "";


    public String $fxtTransaction = "";

    public bool $phased = false;

    public String $ecBlockId = "";
    public int $ecBLockHeight = 0;
    public int $deadline = 0;
    public int $height = 0;
    public int $timestamp = 0;
    public ?Carbon $time = null;

    public String $signature = "";
    public String $signatureHash = "";

    public int $subtype = 0;
    public int $amontNQT = 0;

    public String $sender = "";
    public String $senderRS = "";
    public String $recipient;
    public String $recipientRS = "";

    public function __construct(object $data){
        parent::__construct($data);
        $this->time = $this->transformToGenesisTime($this->timestamp);
    }

}