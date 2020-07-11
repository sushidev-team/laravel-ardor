<?php

namespace AMBERSIVE\Tests\lasses;

use AMBERSIVE\Tests\TestArdorCase;

use AMBERSIVE\Ardor\Classes\ArdorAssetsHandler;

use AMBERSIVE\Ardor\Models\ArdorMockResponse;
use AMBSERIVE\Ardor\Models\ArdorTransaction;

use Carbon\Carbon;

class ArdorAssetsTest extends TestArdorCase
{

    /**
     * Test if a asset can be generated
     */
    public function testArdorAssetsIssuing():void {

        $time = time();

        $ardor = new ArdorAssetsHandler();
        $asset = $ardor
                    ->calculateFee()->issueAsset("${time}", ["test" => true, "time" => $time, 'who' => 'AMBERSIVE KG'], 1, 0, 2);

        $this->assertNotNull($asset);
        $this->assertTrue($asset instanceof \AMBERSIVE\Ardor\Models\ArdorTransaction);

    }

    /*
    public function testArdorAssetsIssuingThousand():void {

        $time = time();

        $ardor = new ArdorAssetsHandler();
        $asset = $ardor
                    ->calculateFee()->issueAsset("${time}", ["test" => true, "time" => $time, 'who' => 'AMBERSIVE KG - 1000'], 1000, 0, 2);

        $this->assertNotNull($asset);
        $this->assertTrue($asset instanceof \AMBERSIVE\Ardor\Models\ArdorTransaction);


    }*/

    /**
     * Test if the get all assets returns a collection for the assets
     */
    public function testArdorAllAssets():void {

        $ardor = new ArdorAssetsHandler();
        $assets = $ardor->getAllAssets();

        $this->assertNotNull($assets);
        $this->assertNotEquals(0, $assets->assets->count());

    }

    /**
     * Test if the Asset search returns a result
     */
    public function testArdorAssetSearch():void {

        $searchTerm = "test OR asdf";

        $ardor  = new ArdorAssetsHandler();
        $assets = $ardor->searchAssets($searchTerm);
        $result = $assets->assets->first();

        $this->assertNotNull($assets);
        $this->assertNotEquals(0, $assets->assets->count());
        $this->assertNotFalse(strpos($result->name.'/'.$result->description, "test") || strpos($result->name.'/'.$result->description, "asdf"));

    }

    /**
     * Test if an asset property can be set
     */
    public function testArdorSetAssetProperty():void {

        $ardor  = new ArdorAssetsHandler();

        $propName  = "CompanyName";
        $propValue = "AMBERSIVE KG";

        $propertySetResult = $ardor->calculateFee()->setAssetProperty("5080855141560730776", $propName, $propValue, 2);

        $this->assertNotNull($propertySetResult);
        $this->assertTrue($propertySetResult instanceof  \AMBERSIVE\Ardor\Models\ArdorTransaction);
        $this->assertEquals($propName, optional($propertySetResult)->transactionJSON->attachment->property);

    }

    /**
     * Test if a property can be deleted successfully
     */
    public function testArdorDeleteAssetProperty():void {

        $ardor  = new ArdorAssetsHandler();
        $last = microtime(true);

        $propName  = "CompanyName";
        $propValue = "AMBERSIVE KG";

        $propertySetResult = $ardor->calculateFee()->setAssetProperty("5080855141560730776", $propName, $propValue, 2);
        
        // Wait until the property was set
        sleep(10);

        $propertyDeleteResult = $ardor->calculateFee()->deleteAssetProperty("5080855141560730776", $propName, 2);

        $now = microtime(true);

        $this->assertNotNull($propertyDeleteResult);
        $this->assertNotNull(optional($propertyDeleteResult)->transactionJSON->attachment);
        $this->assertGreaterThan(10, $now - $last);

    }

    /**
     * Test if an asset can be transfered to someone else
     */
    public function testArdorTransferAssetToAnotherWalletIsSuccessful():void {

        $ardor  = new ArdorAssetsHandler();

        // Action
        $transfer = $ardor->calculateFee()->transferAsset("5080855141560730776", "ARDOR-NJNX-KRD6-JW7T-GU397", 1, 2);

        // Assert
        $this->assertNotNull($transfer);
        $this->assertTrue($transfer->broadcasted);
        $this->assertNotNull(optional($transfer)->transactionJSON->attachment->asset);
        $this->assertEquals("5080855141560730776", optional($transfer)->transactionJSON->attachment->asset);

    }

    /**
     * Test if you can get the assets by his issuer
     */
    public function testArdorGetAssetsByIssuer():void {

        $ardor  = new ArdorAssetsHandler();

        $assets = $ardor->getAssetsByIssuer("ARDOR-DAZJ-VVSM-552M-8K459");

        $this->assertNotNull($assets);
        $this->assertNotEquals(0, $assets->assets->count());

    }

    /**
     * Test if asset ids not empty
     */
    public function testArdorGetAssetIds(): void {

        $ardor  = new ArdorAssetsHandler();

        $assets = $ardor->getAssetIds();

        $this->assertNotNull($assets);
        $this->assertNotEmpty($assets);

    }

    /**
     * Test if the asset history endpoint is accessable
     */
    public function testArdorGetAssetHistory(): void {

        $ardor  = new ArdorAssetsHandler();

        $assets = $ardor->getAssetHistory("10831161563970078263");

        $this->assertNotNull($assets);
        $this->assertNotEquals(0, $assets->assetHistory->count());

    }

}