<?php 

namespace AMBERSIVE\Ardor\Classes;

use AMBERSIVE\Ardor\Classes\ArdorBase;

use Validator;
use Carbon\Carbon;

use AMBERSIVE\Ardor\Classes\ArdorBlockchain;
use AMBERSIVE\Ardor\Classes\ArdorHelper;

use AMBERSIVE\Ardor\Models\ArdorNode;
use AMBERSIVE\Ardor\Models\ArdorTransaction;

class ArdorBundler extends ArdorBase {

    public function __construct(ArdorNode $node = null, \GuzzleHttp\Client $client = null){
        parent::__construct($node, $client);
    }

    public function runBundler(ArdorBundlerSetting $settings) {



    }

    public function bundleTransactions(String $fullHash, int $chain = 0, array $more = []):bool {

        $helper = new ArdorHelper();
        $ardor = new ArdorBlockchain();

        $validator = Validator::make(['transactionFullHash' => $fullHash], [
            'transactionFullHash' => 'required|min:64|max:64'
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }
        
        $transactionBytes = $ardor->getTransactionBytes($fullHash, $chain); 

        $body = array_merge([
            'transactionFullHash' => $fullHash,
            'chain' => 1,
            'secretPhrase' => config('ardor.secret'),
            'deadline' => 15,
            'feeNQT' => $helper->caluclateFeeForTransaction($fullHash, $chain)
        ], $more);

        sleep(1);

        $response = $this->send("bundleTransactions", $body, false, 'form_params', true);

        dd($response);
        
        return new ArdorTransaction($response);

    }

}