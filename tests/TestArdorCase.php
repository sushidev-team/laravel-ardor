<?php


namespace AMBERSIVE\Tests;

use AMBERSIVE\Tests\TestCase;

use Config;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;


class TestArdorCase extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        Config::set('ardor.node', 'https://testardor.jelurida.com/');
        Config::set('ardor.wallet', 'ARDOR-DAZJ-VVSM-552M-8K459');
        Config::set('ardor.secret', 'orange welcome begun powerful lonely government cast figure add quit wife loser');

    }
    
    /**
     * Create a mock for the api calls
     *
     * @param  mixed $responses
     * @return void
     */
    protected function createApiMock(array $responses = [])
    {

        $mock    = new MockHandler(array_map(function($item){
            return $item->get();
        }, $responses));

        $handler = HandlerStack::create($mock);

        return new Client(['handler' => $handler]);

    }


}