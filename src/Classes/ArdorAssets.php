<?php 

namespace AMBERSIVE\Ardor\Classes;

use AMBERSIVE\Ardor\Classes\ArdorBase;
use AMBERSIVE\Ardor\Models\ArdorNode;
use AMBERSIVE\Ardor\Models\ArdorTransaction;
use AMBERSIVE\Ardor\Models\ArdorAssets as ArdorAssetData;

use Validator;
use Carbon\Carbon;

use Illuminate\Validation\ValidationException;

class ArdorAssets extends ArdorBase {

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
            "includeCounts" => "true"
        ], $more, null, false);

        $response = $this->send("getAllAssets", $body, false, 'form_params');

        return new ArdorAssetData($response);

    }


}