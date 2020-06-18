<?php


namespace AMBERSIVE\Ardor\Tests;

use Tests\TestCase;

use Config;

class TestArdorCase extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        Config::set('ardor.node', 'https://testardor.jelurida.com');

    }

    private function createApiMock(array $responses = [], $settings = null)
    {

        /*$mock    = new MockHandler(array_map(function($item){
            return $item->get();
        }, $responses));
        $handler = HandlerStack::create($mock);

        $pdfPrinter = new PdfPrinter($settings === null ? $this->pdfPrinterSettings : $settings, new Client(['handler' => $handler]));

        return $pdfPrinter;*/
    }


}