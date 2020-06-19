<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;

class ArdorServerBlockchainStatus extends ArdorBasic {

    public bool $apiProxy = false;
    public bool $correctInvalidFees = false;

    public int $ledgerTrimKeep = 0;
    public int $maxAPIRecords = 0;

    public ?String $blockchainState = "";

    public int $currentMinRollbackHeight = 0;
    public int $numberOfBlocks = 0;

    public bool $isTestnet = false;
    public bool $includeExpiredPrunable = false;
    public bool $isLightClient = false;

    public array $services = [];

    public int $requestProcessingTime = 0;

    public ?String $version = "0.0.0";

    public int $maxRollback = 0;

    public ?String $lastBlock = "";
    public ?String $application = "";

    public bool $isScanning = false;
    public bool $isDownloading = false;

    public ?String $cumulativeDifficulty = "";

    public int $lastBlockchainFeederHeight = 0;
    public int $maxPrunableLifetime = 0;
    public ?String $lastBlockchainFeeder  = "";

    public function __construct(object $data){
        parent::__construct($data);
    }

}