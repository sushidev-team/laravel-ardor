<?php 

namespace AMBERSIVE\Ardor\Classes;

use AMBERSIVE\Ardor\Classes\ArdorBaseHandler;
use AMBERSIVE\Ardor\Models\ArdorNode;
use AMBERSIVE\Ardor\Models\ArdorTransaction;
use AMBERSIVE\Ardor\Models\ArdorAssets;
use AMBERSIVE\Ardor\Models\ArdorAssetsHistory;

use Validator;
use Carbon\Carbon;

use Illuminate\Validation\ValidationException;

class ArdorAssetsHandler extends ArdorBaseHandler  {

    public function __construct(ArdorNode $node = null, \GuzzleHttp\Client $client = null){
        parent::__construct($node, $client);
    }
    
    /**
     * Creates a new asset on the blockchain (token etc.)
     *
     * @param  mixed $name
     * @param  mixed $description
     * @param  mixed $amount
     * @param  mixed $decimals
     * @param  mixed $chain
     * @param  mixed $more
     * @return ArdorTransaction
     */
    public function issueAsset(String $name, $description = null, int $amount = 1, int $decimals = 0, int $chain = 0, array $more = []):ArdorTransaction {

        // Prepare the description to be
        if ($description === null) {
            $description = "";
        }
        else if (is_array($description)){
            $description = json_encode($description);
        }

        $body = $this->mergeBody([
            'name'        => $name,
            'description' => $description,
            'quantityQNT' => $amount,
            'decimals'    => $decimals,
            'chain'       => $chain        
        ], $more, null, true);

        $validator = Validator::make($body, [
            'name' =>  'required|min:3|max:10',
            'chain' => 'required|int|min:2'
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $response = $this->send("issueAsset", $body, false, 'form_params');

        return new ArdorTransaction($response);

    }
    
    /**
     * Returns a list of assets on the blockchain
     *
     * @param  mixed $more
     * @return ArdorAsset
     */
    public function getAllAssets(array $more =  []): ArdorAssets {

        $body = $this->mergeBody([
            "includeCounts" => true
        ], $more, null, false);

        $response = $this->send("getAllAssets", $body, false, 'form_params');

        return new ArdorAssets($response);

    }
    
    /**
     * Search for assets with a string.
     * The search will be done in the name and in the description.
     *
     * @param  mixed $query
     * @param  mixed $more
     * @return ArdorAssets
     */
    public function searchAssets(String $query, array $more = []): ArdorAssets {

        $body = $this->mergeBody([
            "query" => $query,
            "includeCounts" => true
        ], $more, null, false);

        $response = $this->send("searchAssets", $body, false, 'form_params');

        return new ArdorAssets($response);

    }
    
    /**
     * setAssetProperty
     *
     * @param  mixed $id
     * @param  mixed $property
     * @param  mixed $value
     * @param  mixed $more
     * @return void
     */
    public function setAssetProperty(String $id, String $property, String $value, int $chain = 0, array $more = []): ArdorTransaction {

        $body = $this->mergeBody([
            "asset" => $id,
            "property" => $property,
            "value" => $value,
            "chain" => $chain
        ], $more, null, true);

        $validator = Validator::make($body, [
            'property' =>  'required|min:1|max:32',
            'value'    => 'required|min:1|max:160'
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $response = $this->send("setAssetProperty", $body, false, 'form_params');

        return new ArdorTransaction($response);

    }
    
    /**
     * Delete a property from an asset
     *
     * @param  mixed $id
     * @param  mixed $property
     * @param  mixed $chain
     * @param  mixed $more
     * @return ArdorTransaction
     */
    public function deleteAssetProperty(String $id, String $property, int $chain = 0, array $more = []): ArdorTransaction {

        $body = $this->mergeBody([
            "asset" => $id,
            "property" => $property,
            "chain" => $chain
        ], $more, null, true);

        $response = $this->send("deleteAssetProperty", $body, false, 'form_params');

        return new ArdorTransaction($response);

    }
    
    /**
     * Transfer an asset to another wallet
     *
     * @param  mixed $asset
     * @param  mixed $wallet
     * @param  mixed $amount
     * @param  mixed $chain
     * @param  mixed $more
     * @return ArdorTransaction
     */
    public function transferAsset(String $asset, String $wallet, int $amount = 1, int $chain = 0, array $more = []): ArdorTransaction {

        $body = $this->mergeBody([
            "asset"       => $asset,
            "recipient"   => $wallet,
            "quantityQNT" => $amount,
            "chain"       => $chain
        ], $more, null, true);

        $response = $this->send("transferAsset", $body, false, 'form_params');

        return new ArdorTransaction($response);

    }
    
    /**
     * Get the assets by issuer
     *
     * @param  mixed $wallet
     * @param  mixed $more
     * @return ArdorAssets
     */
    public function getAssetsByIssuer(String $wallet, array $more = []): ArdorAssets {

        $body = $this->mergeBody([
            "account" => $wallet,
        ], $more, null, false);

        $response = $this->send("getAssetsByIssuer", $body, false, 'form_params');
        $assets   = (object) ['assets' => isset($response->assets) ? $response->assets[0] : []];

        return new ArdorAssets($assets);

    }
    
    /**
     * Get asset ids available on the blockchain
     *
     * @param  mixed $more
     * @return array
     */
    public function getAssetIds(array $more = []): array {

        $body = $this->mergeBody([], $more, null, false);

        $response = $this->send("getAssetIds", $body, false, 'form_params');
        
        return $response->assetIds;

    }
    
    /**
     * Returns the history for an asset
     *
     * @param  mixed $asset
     * @param  mixed $more
     * @return ArdorAssetsHistory
     */
    public function getAssetHistory(String $asset, array $more = []): ArdorAssetsHistory {

        $body = $this->mergeBody([
            "asset" => $asset
        ], $more, null, false);

        $response = $this->send("getAssetHistory", $body, false, 'form_params');

        return new ArdorAssetsHistory($response);

    }

}