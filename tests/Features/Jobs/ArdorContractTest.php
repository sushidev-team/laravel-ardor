<?php

namespace AMBERSIVE\Tests\Features\Jobs;

use AMBERSIVE\Tests\TestArdorCase;
use AMBERSIVE\Ardor\Jobs\RunContracts;

use AMBERSIVE\Ardor\Models\ArdorMockResponse;

use AMBERSIVE\Ardor\Classes\ArdorMessengerHandler;

use Carbon\Carbon;

class ArdorContractTest extends TestArdorCase
{

    /**
     * Test if the getTime function returns the server time as
     * Carbon object
     */
    public function testArdorContractJob(): void {

        $messenger = new ArdorMessengerHandler();        
        $resultMessage = $messenger
                            ->setFee(1)
                            ->sendMessage("ARDOR-DAZJ-VVSM-552M-8K459", "test", false, ['broadcast' => true, 'broadcasted' => true]);
        
        $this->expectsJobs(RunContracts::class);

        $job = RunContracts::dispatchNow();

    }

}