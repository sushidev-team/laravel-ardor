<?php 

namespace AMBERSIVE\Ardor\Classes;

use AMBERSIVE\Ardor\Classes\ArdorBase;

use Carbon\Carbon;

use AMBERSIVE\Ardor\Models\ArdorNode;
use AMBERSIVE\Ardor\Models\ArdorServerBlockchainStatus;

class ArdorServer extends ArdorBase {

    public function __construct(ArdorNode $node = null, \GuzzleHttp\Client $client = null){
        parent::__construct($node, $client);
    }
    
    /**
     * Returns a carbon class based on the time of the node
     *
     * @return Carbon
     */
    public function getTime(): Carbon {

        $response = $this->send("getTime");
        return Carbon::createFromTimestamp($response->unixtime); 

    }

    /**
     * Returns the Blockchain Status
     */
    public function getBlockchainStatus(): object {

        $response = $this->send("getBlockchainStatus");
        return new ArdorServerBlockchainStatus($response);

    }

}