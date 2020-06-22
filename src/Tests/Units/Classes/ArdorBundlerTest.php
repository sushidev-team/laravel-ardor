<?php

namespace AMBERSIVE\Ardor\Tests\Unit\Classes;

use AMBERSIVE\Ardor\Tests\TestArdorCase;

use AMBERSIVE\Ardor\Classes\ArdorMessenger;
use AMBERSIVE\Ardor\Classes\ArdorBundler;

use AMBERSIVE\Ardor\Models\ArdorMockResponse;

use Carbon\Carbon;

class ArdorBundlerTest extends TestArdorCase
{

    public function testArdorBundleTransactions():void {

        $messenger = new ArdorMessenger();        
        $resultMessage= $messenger->setFee(1)->sendMessage("ARDOR-DAZJ-VVSM-552M-8K459", "test", false, ['broadcast' => true, 'broadcasted' => true]);

        $bundler = new ArdorBundler();
        $result = $bundler->bundleTransactions($resultMessage->transactionJSON->fullHash, 2, []);

        $this->assertTrue($result);
    }

}