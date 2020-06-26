<?php

namespace AMBERSIVE\Ardor\Tests\Unit\Classes;

use AMBERSIVE\Ardor\Tests\TestArdorCase;

use AMBERSIVE\Ardor\Classes\ArdorMessenger;
use AMBERSIVE\Ardor\Classes\ArdorBlockchain;

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

        $blockchain = new ArdorBlockchain();
        $result = $blockchain
                    ->getTransaction("68df1c0eb56059cae1dbaa57efe161762d57e996e38b844abcad7fd1c017b33d", 2);

        $this->assertNotNull($result);
        $this->assertEquals("68df1c0eb56059cae1dbaa57efe161762d57e996e38b844abcad7fd1c017b33d", $result->fullHash);
    
    }

    /**
     * This test will return a value even if you use the incorrect chain
     */
    public function testArdorBlockchainGetTransactionWonTFailsDueIncorrectChain():void {

        $blockchain = new ArdorBlockchain();
        $result = $blockchain
                    ->getTransaction("68df1c0eb56059cae1dbaa57efe161762d57e996e38b844abcad7fd1c017b33d", 1);

        $this->assertNotNull($result);
        $this->assertEquals("68df1c0eb56059cae1dbaa57efe161762d57e996e38b844abcad7fd1c017b33d", $result->fullHash);

    }

    /**
     * This test will fail due an incorrect chain
     */
    public function testArdorBlockchainGetTransactionFailsDueIncorrectChain():void {

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);

        $blockchain = new ArdorBlockchain();
        $result = $blockchain
                    ->getTransaction("68df1c0eb56059cae1dbaa57efe161762d57e996e38b844abcad7fd1c017b33d", 0);

    }

    /**
     * This test will return a value even if you use the incorrect chain
     */
    public function testArdorBlockchainGetTransactionBytes():void {

        $blockchain = new ArdorBlockchain();
        $result = $blockchain
                    ->getTransactionBytes("68df1c0eb56059cae1dbaa57efe161762d57e996e38b844abcad7fd1c017b33d", 1);

        $this->assertNotNull($result);
        $this->assertTrue(isset($result->unsignedTransactionBytes));
        $this->assertTrue(isset($result->transactionBytes));

        $this->assertNotNull($result->unsignedTransactionBytes);
        $this->assertNotNull($result->transactionBytes);

        dd($result);
    }

}