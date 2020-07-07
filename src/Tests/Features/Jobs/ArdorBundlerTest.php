<?php

namespace AMBERSIVE\Ardor\Tests\Features\Jobs;

use AMBERSIVE\Ardor\Tests\TestArdorCase;
use AMBERSIVE\Ardor\Jobs\RunBundler;

use AMBERSIVE\Ardor\Models\ArdorMockResponse;

use AMBERSIVE\Ardor\Classes\ArdorMessengerHandler;

use Carbon\Carbon;

class ArdorBundlerTest extends TestArdorCase
{

    /**
     * Test if the getTime function returns the server time as
     * Carbon object
     */
    public function testArdorBundlerJob(): void {

        $messenger = new ArdorMessengerHandler();        
        $resultMessage = $messenger
                            //->setClient($this->createApiMock([$responseMessage, $responseTransactionBytes]))
                            ->setFee(1)
                            ->sendMessage("ARDOR-DAZJ-VVSM-552M-8K459", "test", false, ['broadcast' => true, 'broadcasted' => true]);
        
        $this->expectsJobs(RunBundler::class);

        $job = RunBundler::dispatchNow();

    }

}