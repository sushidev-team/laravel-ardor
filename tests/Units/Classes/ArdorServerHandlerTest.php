<?php

namespace AMBERSIVE\Tests\Unit\Classes;

use AMBERSIVE\Tests\TestArdorCase;

use AMBERSIVE\Ardor\Classes\ArdorServerHandler;

use AMBERSIVE\Ardor\Models\ArdorMockResponse;

use Carbon\Carbon;

class ArdorServerHandlerTest extends TestArdorCase
{

    /**
     * Test if the getTime function returns the server time as
     * Carbon object
     */
    public function testArdorGetTimeWillReturnCarbon(): void {

        // Prepare

        $now = Carbon::now();
        $response = new ArdorMockResponse(200, ['unixtime' => time(), 'time' => $now->timestamp, 'requestProcessingTime' => 0]);

        // Tests

        $server = new ArdorServerHandler();

        $result = $server->setClient($this->createApiMock([$response]))->getTime();
        $this->assertEquals($now->toDateTimeString(), $result->toDateTimeString());

    }

    /**
     * Test if getTimeItem() will return ArdorTime class
     */
    public function testArdorGetTimeItemWillReturnArdorTime():void {

        // Prepare

        $now = Carbon::now();
        $response = new ArdorMockResponse(200, ['unixtime' => time(), 'time' => $now->timestamp, 'requestProcessingTime' => 0]);

        // Tests

        $server = new ArdorServerHandler();

        $result = $server->setClient($this->createApiMock([$response]))->getTimeItem();
        $this->assertEquals($now->toDateTimeString(), $result->carbon->toDateTimeString());


    }

    /**
     * Test if the transform to carbon works even if the unix time is missing
     */
    public function testArdorGetTimeWillReturnTimeEvenIfUnixTimeIsMissing():void {

        // Prepare

        $now = Carbon::now();
        $response = new ArdorMockResponse(200, ['time' => $now->timestamp, 'requestProcessingTime' => 0]);

        // Tests

        $server = new ArdorServerHandler();

        $result = $server->setClient($this->createApiMock([$response]))->getTime();
        $this->assertEquals($now->toDateTimeString(), $result->toDateTimeString());

    }

    /**
     * Test if a basic model will be recieved from the api and the 
     * attributes will be set form the result
     */
    public function testArdorGetBlockchainStatusReturnObject(): void {

        // Prepare

        $now = Carbon::now();
        $response = new ArdorMockResponse(200, ['availableFilters' => [
            ['name' => 'TEST']
        ]]);

        // Test

        $server = new ArdorServerHandler();
        $result = $server->setClient($this->createApiMock([$response]))->getBundlingOptions();

        $this->assertNotNull($result);
        $this->assertTrue($result->availableFilters->count() > 0);

        $filter = $result->availableFilters->first();

        $this->assertNotNull($filter);
        $this->assertEquals($filter->name, 'TEST');

    }

    /**
     * Test if the getConstants Methods return Object
     */
    public function testArdorGetConstantsReturnsObject(): void {

        // Prepare

        $now = Carbon::now();
        $response = new ArdorMockResponse(200, [
            'maxNumberOfFxtTransactions' => 1000,
            'transactionSubTypes' => [
                'AssetIssuance' => [
                   "isPhasable" =>  true,
                    "subtype"=>  0,
                    "mustHaveRecipient" =>  false,
                    "name"=>  "AssetIssuance",
                    "canHaveRecipient" =>  false,
                    "isGlobal" =>  true,
                    "type"=>  2,
                    "isPhasingSafe" =>  true
                ],
                'Test' => [
                    "isPhasable" =>  true,
                     "subtype"=>  0,
                     "mustHaveRecipient" =>  false,
                     "name"=>  "AssetIssuance",
                     "canHaveRecipient" =>  false,
                     "isGlobal" =>  true,
                     "type"=>  2,
                     "isPhasingSafe" =>  true
                ]
            ]
        ]);

        $server = new ArdorServerHandler();
        $result = $server->setClient($this->createApiMock([$response]))->getConstants();

        // Tests

        $this->assertNotNull($result);
        $this->assertEquals(2, $result->transactionSubTypes->count());
        $this->assertEquals('Test', $result->transactionSubTypes->last()->name);

    }
    
    /*
     * Test if the getState method returns a valid object
     */
    public function testArdorGetStateReturnsObject(): void {

        $response = new ArdorMockResponse(200, [
            'application' => "ArdorTest",
        ]);

        $server = new ArdorServerHandler();
        $result = $server->setClient($this->createApiMock([$response]))->getState();

        $this->assertEquals($result->application, "ArdorTest");

    }

}