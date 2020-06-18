<?php

namespace AMBERSIVE\Ardor\Tests\Unit\Classes;

use AMBERSIVE\Ardor\Tests\TestArdorCase;

use AMBERSIVE\Ardor\Classes\ArdorServer;

use Carbon\Carbon;

class ArdorServerTest extends TestArdorCase
{

    /**
     * Test if the getTime function returns the server time as
     * Carbon object
     */
    public function testArdorGetTimeWillReturnCarbon(): void {

        $server = new ArdorServer();
        $result = $server->getTime();
        $this->assertEquals(Carbon::now()->toDateTimeString(), $result->toDateTimeString());

    }

    public function testArdorGetBlockchainStatusReturnObject(): void {

        $server = new ArdorServer();
        $result = $server->getBlockchainStatus();
        $this->assertNotNull($result);


    }

}