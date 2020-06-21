<?php

namespace AMBERSIVE\Ardor\Tests\Unit\Classes;

use AMBERSIVE\Ardor\Tests\TestArdorCase;

use AMBERSIVE\Ardor\Classes\ArdorMessenger;

use AMBERSIVE\Ardor\Models\ArdorMockResponse;

use Carbon\Carbon;

class ArdorMessengerTest extends TestArdorCase
{

    public function testIfSendMessageWillReturnObject():void {

        $messenger = new ArdorMessenger();
        $result = $messenger->calculateFee()->sendMessage("ARDOR-DAZJ-VVSM-552M-8K459", "test");

        $this->assertNotNull($result);
        // TODO: Continue the testing here

    }

}