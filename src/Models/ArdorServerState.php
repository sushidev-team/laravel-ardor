<?php 

namespace AMBERSIVE\Ardor\Models;

use AMBERSIVE\Ardor\Models\ArdorBasic;
use AMBERSIVE\Ardor\Models\ArdorBlock;
use AMBERSIVE\Ardor\Models\ArdorTransactionSubType;

use Illuminate\Support\Collection;

class ArdorServerState extends ArdorBasic {

    public String $application = "Ardor";

    public int $numberOfPeers = 0;
    public int $numberOfUnlockedAccounts = 0;
    public int $numberOfConnectedPeers = 0;
    public int $numberOfBlocks = 0;

    public bool $correctInvalidFeeds = false;

    public int $ledgerTrimKeep = 0;
    public int $maxAPIRedords = 1;
    public String $blockchainState = "";

    public bool $includeExpiredPrunable = false;

    public int $freeMemory = 0;
    public int $maxMemory = 0;
    public int $totalMemory = 0;
    public int $maxRollback = 0;

    public bool $isScanning = false;
    public bool $isDownloading = false;
    public bool $isTestnet = false;
    public bool $isLightClient = false;
    public bool $isOffline = false;

    public String $cumulativeDifficulty = "";

    public int $peerPort = 26874;
    public bool $apiProxy = false;

    public int $availableProcessors = 1;
    public bool $needsAdminPassword = false;

    public int $currentMinRollbackHeight = 0;

    public array $services = [];

    public String $version = "0.0.1";

    public String $lastBlock = "";
    public int $lastBlockchainFeederHeight = 0;
    public String $lastBlockchainFeeder = "";

    public int $maxPrunableLifetime = 0;

    public function __construct(object $data){
        parent::__construct($data);
    }

}