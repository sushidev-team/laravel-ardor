<?php 

namespace AMBERSIVE\Ardor\Classes;

use AMBERSIVE\Ardor\Classes\ArdorBaseHandler;
use AMBERSIVE\Ardor\Models\ArdorNode;
use AMBERSIVE\Ardor\Models\ArdorTransaction;
use AMBERSIVE\Ardor\Models\ArdorAssets as ArdorAssetData;

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
    public function getAllAssets(array $more =  []): ArdorAssetData {

        $body = $this->mergeBody([
            "includeCounts" => true
        ], $more, null, false);

        $response = $this->send("getAllAssets", $body, false, 'form_params');

        return new ArdorAssetData($response);

    }
    
    /**
     * Search for assets with a string.
     * The search will be done in the name and in the description.
     *
     * @param  mixed $query
     * @param  mixed $more
     * @return ArdorAssetData
     */
    public function searchAssets(String $query, array $more = []): ArdorAssetData {

        $body = $this->mergeBody([
            "query" => $query,
            "includeCounts" => true
        ], $more, null, false);

        $response = $this->send("searchAssets", $body, false, 'form_params');

        return new ArdorAssetData($response);

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
    public function setAssetProperty(String $id, String $property, String $value, int $chain = 0, array $more = []) {

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


}