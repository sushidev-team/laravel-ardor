<?php

namespace AMBERSIVE\Tests\Unit\Classes;

use Config;

use AMBERSIVE\Tests\TestArdorCase;

use AMBERSIVE\Ardor\Classes\ArdorServerHandler;
use AMBERSIVE\Ardor\Classes\ArdorMessengerHandler;
use AMBERSIVE\Ardor\Classes\ArdorHelper;

use AMBERSIVE\Ardor\Models\ArdorMockResponse;

use Carbon\Carbon;
use Mockery\Mockery;

class ArdorBaseTest extends TestArdorCase
{

    public function testArdorSendChained():void {

        // Prepare

        $now = Carbon::now();
        $response = new ArdorMockResponse(200, ['time' => $now->timestamp, 'requestProcessingTime' => 0]);
        
        // Tests

        $server = new ArdorServerHandler();

        $result = $server->setClient($this->createApiMock([$response, $response]))->sendChained("getTime")->sendChained("getTime")->resolve();
        $this->assertEquals(2, sizeOf($result));

    }

    /**
     * Test if local signing will fail if config is not active
     */
    public function testIfArdorUsingSignLocalResultInFailIfUsed():void {

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);

        $messenger = new ArdorMessengerHandler();   
        $result = $messenger
                    ->signLocal()
                    ->calculateFee()
                    ->sendMessage("ARDOR-DAZJ-VVSM-552M-8K459", "asdf", false);

    }

    /**
     * Test if transaction can be send by using the local signing
     */
    public function testIfArdorUsingSignLocalWillBeSuccessfulIfUsed():void {


        Config::set('ardor.localSignAvailable', true);

        $messenger = new ArdorMessengerHandler();   

        $mocked = \Mockery::mock(ArdorHelper::class);
        $mocked->shouldReceive('signTransaction')->andReturn(['Signed Transaction is:','020000000100015008cd040f00850ec0aeeadd6c71804128f422cb621b89072805fa228be4369fe0e9d25d1309f0a335f1de518c63000000000000000080841e00000000002819aef3576e2b311c28113347b9a2eb45d1f654855ee984db39cfab4fda4c0e38011d6b578869d10754a775a933e1f01808dd3ad2934d082a12c8431c877bbfe0724e00587e5fe74211581a010000000101040061736466000000000000000000000000000000000000000000000000000000000000000000000000']);

        $messenger = new ArdorMessengerHandler();
        $result    = $messenger
                    ->signLocal($mocked)
                    ->calculateFee()
                    ->sendMessage("ARDOR-DAZJ-VVSM-552M-8K459", "asdf", false);

        $this->assertNotNull($result);

    }

    public function testIfArdorCanGenerateVoucher():void {

        $messenger = new ArdorMessengerHandler();
        $result    = $messenger
                    ->isVoucher("850ec0aeeadd6c71804128f422cb621b89072805fa228be4369fe0e9d25d1309")
                    ->calculateFee()
                    ->sendMessage("ARDOR-EBWQ-2TS5-PC65-747P5", "asdf", false, []);

        $voucher = $result->transformToVoucher("sendMessage");

    }

}