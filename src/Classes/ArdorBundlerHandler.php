<?php 

namespace AMBERSIVE\Ardor\Classes;

use AMBERSIVE\Ardor\Classes\ArdorBaseHandler;

use Validator;
use Carbon\Carbon;

use AMBERSIVE\Ardor\Classes\ArdorBlockchainHandler;
use AMBERSIVE\Ardor\Classes\ArdorHelperHandler;

use AMBERSIVE\Ardor\Models\ArdorNode;
use AMBERSIVE\Ardor\Models\ArdorTransaction;

class ArdorBundlerHandler extends ArdorBaseHandler  {

    public function __construct(ArdorNode $node = null, \GuzzleHttp\Client $client = null){
        parent::__construct($node, $client);
    }

    public function runBundler(ArdorBundlerSetting $settings) {



    }
    
    /**
     * Bundle transactions by fullhash
     *
     * @param  mixed $fullHash
     * @param  mixed $chain
     * @param  mixed $more
     * @return bool
     */
    public function bundleTransactions(String $fullHash, int $chain = 0, array $more = []):bool {

        $helper = new ArdorHelperHandler();
        $ardor  = new ArdorBlockchainHandler();

        $validator = Validator::make(['transactionFullHash' => $fullHash], [
            'transactionFullHash' => 'required|min:64|max:64'
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $transactionBytes = $ardor->getTransactionBytes($fullHash, $chain); 

        $body = $this->mergeBody([
            'transactionFullHash' => $fullHash,
            'chain' => 1,
            'childChain' => $chain,
            'isParentChainTransaction' => 1,      
            'feeNQT' => $helper->caluclateFeeForTransaction($fullHash, $chain),
            'deadline' => 14,
            'transactionPriority' => 1
        ], $more, data_get($more, 'secretPhrase', null), true);

        $response = $this->send("bundleTransactions", $body, false, 'form_params', true);
        
        return !isset($response->errorCode);

    }

}