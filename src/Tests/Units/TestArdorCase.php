<?php


namespace AMBERSIVE\Ardor\Tests;

use Tests\TestCase;

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
        Config::set('ardor.node', 'https://ardor.picapipe.dev');

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