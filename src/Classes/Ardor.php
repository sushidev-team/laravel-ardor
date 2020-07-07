<?php 

namespace AMBERSIVE\Ardor\Classes;

use Carbon\Carbon;

use AMBERSIVE\Ardor\Classes\ArdorAccountsHandler;
use AMBERSIVE\Ardor\Classes\ArdorAssetsHandler;
use AMBERSIVE\Ardor\Classes\ArdorBlockchainHandler;
use AMBERSIVE\Ardor\Classes\ArdorBundlerHandler;
use AMBERSIVE\Ardor\Classes\ArdorConnectorHandler;
use AMBERSIVE\Ardor\Classes\ArdorHelperHandler;
use AMBERSIVE\Ardor\Classes\ArdorMessengerHandler;
use AMBERSIVE\Ardor\Classes\ArdorServerHandler;

use AMBERSIVE\Ardor\Models\ArdorNode;

class Ardor {

    public ArdorAccountsHandler $accounts;
    public ArdorAssetsHandler $assets;
    public ArdorBlockchainHandler $chain;
    public ArdorBundlerHandler $bundler;
    public ArdorConnectorHandler $connector;
    public ArdorHelperHandler $helper;
    public ArdorMessengerHandler $messenger;
    public ArdorServerHandler $server;

    public function __construct(ArdorNode $node = null, \GuzzleHttp\Client $client = null){
        $this->accounts     = new ArdorAccountsHandler($node, $client);
        $this->assets       = new ArdorAssetsHandler($node, $client);
        $this->chain        = new ArdorBlockchainHandler($node, $client);
        $this->bundler      = new ArdorBundlerHandler($node, $client);
        $this->connector    = new ArdorConnectorHandler($node, $client);
        $this->helper       = new ArdorHelperHandler($node, $client);
        $this->messenger    = new ArdorMessengerHandler($node, $client);
        $this->server       = new ArdorServerHandler($node, $client);
    }

}