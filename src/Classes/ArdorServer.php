<?php 

namespace AMBERSIVE\Ardor\Classes;

use AMBERSIVE\Ardor\Classes\ArdorBase;

use Carbon\Carbon;

use AMBERSIVE\Ardor\Models\ArdorNode;
use AMBERSIVE\Ardor\Models\ArdorServerBlockchainStatus;
use AMBERSIVE\Ardor\Models\ArdorServerBundlingOptions;
use AMBERSIVE\Ardor\Models\ArdorServerConstants;
use AMBERSIVE\Ardor\Models\ArdorServerState;
use AMBERSIVE\Ardor\Models\ArdorServerPlugins;

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
        return Carbon::createFromTimestamp(isset($response->unixtime) ? $response->unixtime : $response->time); 

    }
    
    /**
     * Returns the ardor blockchain status
     *
     * @return ArdorServerBlockchainStatus
     */
    public function getBlockchainStatus(): ArdorServerBlockchainStatus {

        $response = $this->send("getBlockchainStatus");
        return new ArdorServerBlockchainStatus($response);

    }
   
    /**
     *  Returns the Bundling options on this node
     *
     * @return ArdorServerBundlingOptions
     */
    public function getBundlingOptions(): ArdorServerBundlingOptions {

        $response = $this->send("getBundlingOptions");
        return new ArdorServerBundlingOptions($response);

    }
    
    /**
     * Returns the contstants of this node
     *
     * @return ArdorServerConstants
     */
    public function getConstants(): ArdorServerConstants {

        $response = $this->send("getConstants");
        return new ArdorServerConstants($response);

    }

    /**
     * Returns the state
     *
     * @param  mixed $chain
     * @param  mixed $includeCounts
     * @param  mixed $asAdmin
     * @return ArdorServerState
     */
    public function getState(int $chain = 1, bool $includeCounts = false, bool $asAdmin = false): ArdorServerState {

        $response = $this->send("getState", [
            'chain' => $chain,
            'includeCounts' => $includeCounts            
        ], $asAdmin);

        return new ArdorServerState($response);

    }
    
    /**
     * Returns a list of all plugins available on this node
     *
     * @return ArdorServerPlugins
     */
    public function getPlugins(): ArdorServerPlugins{

        $response = $this->send("getPlugins");
        return new ArdorServerPlugins($response);

    }

}