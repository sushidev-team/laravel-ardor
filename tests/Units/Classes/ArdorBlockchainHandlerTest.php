<?php

namespace AMBERSIVE\Tests\Unit\Classes;

use AMBERSIVE\Tests\TestArdorCase;

use AMBERSIVE\Ardor\Classes\ArdorMessengerHandler;
use AMBERSIVE\Ardor\Classes\ArdorBlockchainHandler;

use AMBERSIVE\Ardor\Models\ArdorMockResponse;
use AMBERSIVE\Ardor\Models\ArdorMessage;

use Carbon\Carbon;

class ArdorBlockchainTest extends TestArdorCase
{

    /**
     * Returns a object with transaction data
     * It will not return a specific class cause the response varies 
     */
    public function testArdorBlockchainGetTransaction():void {

        // Prepare
        $responseMessage = new ArdorMockResponse(200, ["fullHash" => "68df1c0eb56059cae1dbaa57efe161762d57e996e38b844abcad7fd1c017b33d"]);

        // Test
        $blockchain = new ArdorBlockchainHandler();
        $result = $blockchain
                    ->setClient($this->createApiMock([$responseMessage]))      
                    ->getTransaction("68df1c0eb56059cae1dbaa57efe161762d57e996e38b844abcad7fd1c017b33d", 2);

        $this->assertNotNull($result);
        $this->assertEquals("68df1c0eb56059cae1dbaa57efe161762d57e996e38b844abcad7fd1c017b33d", $result->fullHash);
    
    }

    /**
     * This test will return a value even if you use the incorrect chain
     */
    public function testArdorBlockchainGetTransactionWonTFailsDueIncorrectChain():void {

        // Prepare
        $responseMessage = new ArdorMockResponse(200, ["fullHash" => "68df1c0eb56059cae1dbaa57efe161762d57e996e38b844abcad7fd1c017b33d"]);

        // Test
        $blockchain = new ArdorBlockchainHandler();
        $result = $blockchain
                    ->setClient($this->createApiMock([$responseMessage]))
                    ->getTransaction("68df1c0eb56059cae1dbaa57efe161762d57e996e38b844abcad7fd1c017b33d", 1);

        $this->assertNotNull($result);
        $this->assertEquals("68df1c0eb56059cae1dbaa57efe161762d57e996e38b844abcad7fd1c017b33d", $result->fullHash);

    }

    /**
     * This test will fail due an incorrect chain
     */
    public function testArdorBlockchainGetTransactionFailsDueIncorrectChain():void {

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);

        $blockchain = new ArdorBlockchainHandler();
        $result = $blockchain
                    ->getTransaction("68df1c0eb56059cae1dbaa57efe161762d57e996e38b844abcad7fd1c017b33d", 0);

    }

    /**
     * This test will return a value even if you use the incorrect chain
     */
    public function testArdorBlockchainGetTransactionBytes():void {

        // Prepare
        $responseMessage = new ArdorMockResponse(200, [
            "unsignedTransactionBytes" => "020000000100010f04b4040f00850ec0aeeadd6c71804128f422cb621b89072805fa228be4369fe0e9d25d1309f0a335f1de518c6300000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000008d3d4c009e95d1ccdb70f744010000000101040074657374000000000000000000000000000000000000000000000000000000000000000000000000",
            "requestProcessingTime" =>  0,
            "transactionBytes" => "020000000100010f04b4040f00850ec0aeeadd6c71804128f422cb621b89072805fa228be4369fe0e9d25d1309f0a335f1de518c6300000000000000000000000000000000e3bd3f9542a9419f3cd99365828089ff06a6b0094734bdce6bb8dc41115f1b02190327eaed5c25bec826009b2f31e039bd16ac6d301c3c739f4d0ac24a9decd68d3d4c009e95d1ccdb70f744010000000101040074657374000000000000000000000000000000000000000000000000000000000000000000000000"
        ]);

        // Test
        $blockchain = new ArdorBlockchainHandler();
        $result = $blockchain
                    ->setClient($this->createApiMock([$responseMessage]))
                    ->getTransactionBytes("68df1c0eb56059cae1dbaa57efe161762d57e996e38b844abcad7fd1c017b33d", 1);

        $this->assertNotNull($result);
        $this->assertTrue(isset($result->unsignedTransactionBytes));
        $this->assertTrue(isset($result->transactionBytes));

        $this->assertNotNull($result->unsignedTransactionBytes);
        $this->assertNotNull($result->transactionBytes);

    }

    /**
     * Test if the getUnconfirmedTransactions returns a ArdorTransactionCollection
     */
    public function testArdorBlockchainGetUnconfirmedTransactions():void {

        // Prepare

        $messenger = new ArdorMessengerHandler();        
        $resultMessage = $messenger
                            ->setFee(1)
                            ->sendMessage("ARDOR-DAZJ-VVSM-552M-8K459", "test", false, ['broadcast' => true, 'broadcasted' => true]);

        // Test
        $blockchain = new ArdorBlockchainHandler();
        $result = $blockchain->getUnconfirmedTransactions(2);
        
        $this->assertNotNull($result);
        $this->assertTrue(isset($result->transactions));
        $this->assertTrue($result->transactions->count() > 0);
        $this->assertTrue($result instanceof \AMBERSIVE\Ardor\Models\ArdorTransactionCollection);
    }

}