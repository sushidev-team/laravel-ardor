<?php

namespace AMBERSIVE\Ardor\Tests\Unit\Classes;

use AMBERSIVE\Ardor\Tests\TestArdorCase;

use AMBERSIVE\Ardor\Classes\ArdorAssets;

use AMBERSIVE\Ardor\Models\ArdorMockResponse;

use Carbon\Carbon;

class ArdorAssetsTest extends TestArdorCase
{

    public function testArdorAssetsIssuing():void {

        $time = time();

        $response = new ArdorMockResponse(200, ['accountCurrencies' => []]);

        $ardor = new ArdorAssets();
        $asset = $ardor
                //        ->setClient($this->createApiMock([$response]))
                        ->calculateFee()
                        ->issueAsset("${time}", ["test" => true], 1, 0, 2);

        $this->assertNotNull($asset);
        $this->assertTrue($asset instanceof \AMBERSIVE\Ardor\Models\ArdorTransaction);

    }

}