<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;
use AMBERSIVE\Ardor\Models\ArdorTransactionJson;

use Illuminate\Support\Collection;

class ArdorTransaction extends ArdorBasic {

    public int $minimumFeeFQT = 0;
    public String $signatureHash = "";

    public String $unsignedTransactionBytes = "";

    public ?ArdorTransactionJson $transactionJSON = null;

    public bool $broadcasted = false;
    public int $requestProcessingTime = 0;
    public String $transactionBytes = "";
    public String $fullHash = "";
    public String $bundlerRateNQTPerFXT = "";

    public function __construct(object $data){
        parent::__construct($data);
        $this->transactionJSON = isset($data->transactionJSON) ? new ArdorTransactionJson($data->transactionJSON) : new ArdorTransactionJson((object) []);
    }

}