<?php

namespace AMBERSIVE\Ardor\Tests\Unit\Classes;

use AMBERSIVE\Ardor\Tests\TestArdorCase;

use AMBERSIVE\Ardor\Classes\ArdorMessenger;
use AMBERSIVE\Ardor\Models\ArdorTransaction;
use AMBERSIVE\Ardor\Models\ArdorMockResponse;

use Carbon\Carbon;

class ArdorMessengerTest extends TestArdorCase
{

    /**
     * Test if 2 transactions will be triggered and the fee will set correctly after the first request
     */
    public function testIfSendMessageWillReturnObject():void {

        $responsePreCalculation = new ArdorMockResponse(200, ['broadcasted' => false, 'transactionJSON' => [
            'feeNQT' => 999
        ]]);

        $responsePostCalculation = new ArdorMockResponse(200, ['broadcasted' => true]);

        // Test

        $messenger = new ArdorMessenger();        
        $result = $messenger->setClient($this->createApiMock([$responsePreCalculation,$responsePostCalculation]))->calculateFee()->sendMessage("ARDOR-DAZJ-VVSM-552M-8K459", "test");

        $this->assertNotNull($result);
        $this->assertTrue($result->broadcasted);
        $this->assertEquals(999, $messenger->getFee());

    }

    /**
     * Test if the read message will return structure
     */
    public function testIfReadMessageWillReturnObject():void {

        $response = new ArdorMockResponse(200, ['message' => "test"]);

        $messenger = new ArdorMessenger();
        $resultRead = $messenger->setClient($this->createApiMock([$response]))->readMessage("1cc4b85db37461e84c28dcad92bfc873fd51a04f3af59af164f22f0c3fad2ebb", 2);
        $this->assertEquals("test", $resultRead->message);

    }

    /**
     * Test if a encrypted message can be read
     */
    public function testIfReadMessageOfEncryptedMessageWillReturnObject():void {

        $response = new ArdorMockResponse(200, ['decryptedMessage' => "test"]);

        $messenger = new ArdorMessenger();
        $resultRead = $messenger->setClient($this->createApiMock([$response]))->readMessage("9c1d099705a3cf6251bbd5431775eaf173048baa5ca8d8d1dcf4768c3a874659", 2);

        $this->assertEquals("test", $resultRead->message);

    }

}