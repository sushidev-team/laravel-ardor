<?php

namespace AMBERSIVE\Ardor\Tests\Unit\Classes;

use AMBERSIVE\Ardor\Tests\TestArdorCase;

use AMBERSIVE\Ardor\Classes\ArdorServer;

use AMBERSIVE\Ardor\Models\ArdorMockResponse;

use Carbon\Carbon;

class ArdorBaseTest extends TestArdorCase
{

    public function testArdorSendChained():void {

        // Prepare

        $now = Carbon::now();
        $response = new ArdorMockResponse(200, ['time' => $now->timestamp, 'requestProcessingTime' => 0]);
        
        // Tests

        $server = new ArdorServer();

        $result = $server->setClient($this->createApiMock([$response, $response]))->sendChained("getTime")->sendChained("getTime")->resolve();
        $this->assertEquals(2, sizeOf($result));

    }

}