<?php 

namespace AMBERSIVE\Ardor\Classes;

use AMBERSIVE\Ardor\Classes\ArdorBase;
use AMBERSIVE\Ardor\Classes\ArdorBlockchain;

use Carbon\Carbon;

use AMBERSIVE\Ardor\Models\ArdorNode;
use AMBERSIVE\Ardor\Models\ArdorFee;

class ArdorHelper extends ArdorBase {

    public function __construct(ArdorNode $node = null, \GuzzleHttp\Client $client = null){
        parent::__construct($node, $client);
    }
    
    /**
     * Calculate the required fee by calling the specific blockchain function
     *
     * @param  mixed $bytes
     * @return int
     */
    public function calculateFeeByBlockchainRequest(String $bytes): int{
        $fee = $this->calculateFeeObjectByBlockchainRequest($bytes);
        return $fee->feeNQT;
    }
    
    /**
     * Calculate the required fee and return the ArdorFee for that
     *
     * @param  mixed $bytes
     * @return ArdorFee
     */
    public function calculateFeeObjectByBlockchainRequest(String $bytes): ArdorFee {
        $response = $this->send("calculateFee", [
            'transactionBytes' => $bytes
        ], false, 'form_params');
        return new ArdorFee($response);
    }
    
    /**
     * Get the minimum fee for a specific transaction
     *
     * @param  mixed $fullHash
     * @param  mixed $chain
     * @return int
     */
    public function caluclateFeeForTransaction(String $fullHash, int $chain = 0): int {
        $ardor = new ArdorBlockchain();
        $response = $ardor->getTransactionBytes($fullHash, $chain);
        return $this->calculateFeeByBlockchainRequest($response->transactionBytes);
    }
    
    /**
     * Returns the epoche time for a unix timestamp
     *
     * @param  mixed $unixtimestamp
     * @return int
     */
    public function getEpochTime(int $unixtimestamp = 0):int {

        $response = $this->send("getEpochTime", [
            'timestamp' => $unixtimestamp
        ], false, 'form_params');

        return $response->time;

    }

}