<?php

namespace AMBERSIVE\Tests\Unit\Classes;

use AMBERSIVE\Tests\TestArdorCase;

use AMBERSIVE\Ardor\Classes\ArdorMessengerHandler;
use AMBERSIVE\Ardor\Classes\ArdorBundlerHandler;

use AMBERSIVE\Ardor\Models\ArdorMockResponse;

use Carbon\Carbon;

class ArdorBundlerTest extends TestArdorCase
{

    public function testArdorBundleTransactions():void {

        // Prepare

        $responseMessage = new ArdorMockResponse(200, ['decryptedMessage' => "test", "transactionJSON" => [
            "fullHash" => "e1f16d7ba0050c417b1e6933121a6549523abdd7c83fd1e2b863940384819cf9"
        ]]);

        $responseTransactionBytes = new ArdorMockResponse(200, [
            'requestProcessingTime' => 1,
            'transactionBytes' => "020000000100017c4eaf040f00850ec0aeeadd6c71804128f422cb621b89072805fa228be4369fe0e9d25d1309f0a335f1de518c6300000000000000000100000000000000d573857d3b39773c373eab441dc1bcd0455d3fcc3223fbda51a74e9635b60707f317bdfa2f63ce59e1818af8c2b96d810652645ccb091c6671541de90684fe1cadd34b00e1854decd90d4107010000000101040074657374000000000000000000000000000000000000000000000000000000000000000000000000",
            'unsignedTransactionBytes' => "020000000100017c4eaf040f00850ec0aeeadd6c71804128f422cb621b89072805fa228be4369fe0e9d25d1309f0a335f1de518c630000000000000000010000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000add34b00e1854decd90d4107010000000101040074657374000000000000000000000000000000000000000000000000000000000000000000000000"
        ]);

        $responseFee = new ArdorMockResponse(200, [
            'requestProcessingTime' => 1,
            'feeFQT' => 2000000,
            'minimumFeeFQT' => 1000000
        ]); 

        $responseTransaction = new ArdorMockResponse(200, [
            'broadcasted' => true,
            "transactionJSON" => [
                "fullHash" => "e1f16d7ba0050c417b1e6933121a6549523abdd7c83fd1e2b863940384819cf9"
            ]
        ]); 

        // Test

        $messenger = new ArdorMessengerHandler();        
        $resultMessage = $messenger
                            ->setClient($this->createApiMock([$responseMessage, $responseTransactionBytes]))
                            ->setFee(1)
                            ->sendMessage("ARDOR-DAZJ-VVSM-552M-8K459", "test", false, ['broadcast' => true, 'broadcasted' => true]);

        $bundler = new ArdorBundlerHandler();
        $result = $bundler
                    ->setClient($this->createApiMock([$responseTransaction]))
                    ->bundleTransactions($resultMessage->transactionJSON->fullHash, 2, []);

        $this->assertTrue($result);
    }

}