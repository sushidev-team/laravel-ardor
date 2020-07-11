<?php

namespace AMBERSIVE\Tests\Unit\Classes;

use AMBERSIVE\Tests\TestArdorCase;

use AMBERSIVE\Ardor\Classes\Ardor;

use AMBERSIVE\Ardor\Models\ArdorMockResponse;

use Carbon\Carbon;

class ArdorTest extends TestArdorCase
{

    /**
     * Test if no exception occurs and methods are available throuh the class
     */
    public function testArdorMainClass(): void {

        // Prepare

        $now = Carbon::now();
        $response = new ArdorMockResponse(200, ['unixtime' => time(), 'time' => $now->timestamp, 'requestProcessingTime' => 0]);

        // Tests

        $ardor = new Ardor();

        $result = $ardor->server->setClient($this->createApiMock([$response]))->getTime();
        $this->assertEquals($now->toDateTimeString(), $result->toDateTimeString());

    }

}