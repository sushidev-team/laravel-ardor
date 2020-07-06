<?php

namespace AMBERSIVE\Ardor\Tests\Unit\Classes;

use AMBERSIVE\Ardor\Tests\TestArdorCase;

use AMBERSIVE\Ardor\Classes\ArdorAssets;

use AMBERSIVE\Ardor\Models\ArdorMockResponse;

use Carbon\Carbon;

class ArdorAssetsTest extends TestArdorCase
{

    /**
     * Test if a asset can be generated
     */
    public function testArdorAssetsIssuing():void {

        $time = time();

        $ardor = new ArdorAssets();
        $asset = $ardor
                    ->calculateFee()->issueAsset("${time}", ["test" => true, "time" => $time], 1, 0, 2);

        $this->assertNotNull($asset);
        $this->assertTrue($asset instanceof \AMBERSIVE\Ardor\Models\ArdorTransaction);

    }

    /**
     * Test if the get all assets returns a collection for the assets
     */
    public function testArdorAllAssets():void {

        $ardor = new ArdorAssets();
        $assets = $ardor->getAllAssets();

        $this->assertNotNull($assets);
        $this->assertNotEquals(0, $assets->assets->count());

    }

    /**
     * Test if the Asset search returns a result
     */
    public function testArdorAssetSearch():void {

        $searchTerm = "test OR asdf";

        $ardor = new ArdorAssets();
        $assets = $ardor->searchAssets($searchTerm);

        $this->assertNotNull($assets);
        $this->assertNotEquals(0, $assets->assets->count());

        $result = $assets->assets->first();

        $this->assertNotFalse(strpos($result->name.'/'.$result->description, "test") || strpos($result->name.'/'.$result->description, "asdf"));

    }

}