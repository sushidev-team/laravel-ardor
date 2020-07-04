<?php 

namespace AMBERSIVE\Ardor\Classes;

use App;
use Cache;
use Log;
use Validator;

use AMBERSIVE\Ardor\Models\ArdorNode;
use AMBERSIVE\Ardor\Models\ArdorTransaction;

use GuzzleHttp\Exception\GuzzleException;
use \GuzzleHttp\Client;

class ArdorBase {

    public ArdorNode $node;
    public Client $client;
    
    public array  $results = [];

    public bool $shouldCalculateFee = false;
    public bool $shouldUseCache = true;

    public int $fee = 0;
    public int $chain = 2;
    public int $overPayInPercent = 0;

    public function __construct(ArdorNode $node = null, \GuzzleHttp\Client $client = null){
        $this->node = $node != null ? $node : new ArdorNode();
        $this->client = $client != null ? $client : new Client();
    }
    
    /**
     * Define this call to be automaticaly 
     *
     * @param  mixed $overPayFactor
     * @return ArdorBase
     */
    public function calculateFee(): ArdorBase {
        $this->shouldCalculateFee = true;
        return $this;
    }

    public function setOverpay(int $overPayInPercent = 0): ArdorBase {
        $this->overPayInPercent = $overPayInPercent;
        return $this;
    }

    public function enableCache(): ArdorBase{
        $this->shouldUseCache = true;
        return $this;
    }
    
    public function disableCache(): ArdorBase{
        $this->shouldUseCache = false;
        return $this;
    }

    /**
     * Set the fee for a command
     *
     * @param  mixed $overPayFactor
     * @return ArdorBase
     */
    public function setFee(int $fee): ArdorBase {
        $this->fee = $fee + ($fee / 100 * $this->overPayInPercent);
        return $this;
    }

    /**
     * Returns the calcualted fee
     */
    public function getFee(int $overPayFactor = null): int {
        return $this->fee ;
    }
    
    /**
     * Define the chain you want to trigger the command
     *
     * @param  mixed $chain
     * @return ArdorBase
     */
    public function setChain(int $chain = 1): ArdorBase {
        $this->chain = $chain;
        return $this;
    }
    
    /**
     * Define a GuzzleHttpClient (primarly for testing purpose)
     *
     * @param  mixed $client
     * @return void
     */
    public function setClient(\GuzzleHttp\Client $client): ArdorBase {
        $this->client = $client;
        return $this;
    }
   
    /**
     * Switch the ardor node on the fly
     *
     * @param  mixed $node
     * @return ArdorBase
     */
    public function setNode(ArdorNode $node = null): ArdorBase {
        $this->node = $node != null ? $node : new ArdorNode();
        return $this;
    }
        
    /**
     * Reset the results recieved by the api
     *
     * @return ArdorBase
     */
    public function reset(): ArdorBase {
        $this->results = [];
        $this->setFee(0)->setOverpay(0);
        return $this;
    }
    
    /**
     * Returns an array of api results (if you used sendChained)
     *
     * @param  mixed $reset
     * @return array
     */
    public function resolve(bool $reset = false): array {

        $result = $this->results;
        if ($reset === true) {
            $this->reset();
        }

        return $result;
    }
    
    /**
     * Returns the url for the api endpoint
     *
     * @param  mixed $method
     * @return String
     */
    public function url(String $method): String {
        $url = $this->node->url;
        return "${url}/nxt?requestType=${method}";
    }

    /**
     * Send the request to the block chain
     *
     * @param  mixed $method
     * @param  mixed $body
     * @param  mixed $asAdmin
     * @param  mixed $type
     * @return object
     */
    public function send(String $method, array $body = [], bool $asAdmin = false, $type = 'json', $returnErrors = false): object{

        $json = (object) [];
        $url = $this->url($method);

        try {

            $id = sha1("ARDOR_".$method.json_encode($body).$asAdmin.$type);

            // Check if there is a cached result to speed up the performance of the requests
            if ($this->shouldUseCache === true && config('ardor.cache_send') === true) {
                $cacheResult = Cache::store(config('ardor.cache_driver'))->get($id);
                if ($cacheResult !== null) {
                    Log::debug("[ARDOR]: SEND (CACHED) ${method} / ${url}");
                    return $cacheResult;
                }
            }

            if ($asAdmin === true) {
                $body['adminPassword'] = config('ardor.adminPassword');
            }

            if ($this->shouldCalculateFee === true) {
                
                $this->shouldCalculateFee = false;

                $shouldBroadcast = data_get($body, 'broadcasted', true);

                $body["broadcasted"] = false;
                $body["broadcast"]   = false;

                $res = new ArdorTransaction($this->send($method, $body, $asAdmin, $type));

                $this->setFee($res->transactionJSON->feeNQT != 0 ? $res->transactionJSON->feeNQT : 1000000);

                $body["broadcast"]   = $shouldBroadcast;  
                $body["broadcasted"] = $shouldBroadcast;
                $body["feeNQT"] = $this->getFee();

            }
            else {
                $body["broadcast"]   = true;  
                $body["broadcasted"] = true;
                $body["feeNQT"]      = $this->getFee();
            }

            $response = $this->client->request("POST", $url, [
                'headers' => [],
                "${type}" => $body
            ]);

            $json = $response === null ? null : json_decode($response->getBody());

            if ($returnErrors === false && isset($json->errorCode) && isset($json->error)){
                abort(400, $json->error);
            }
            else if ($returnErrors === false && isset($json->errorCode) && isset($json->errorDescription)){
                abort(400, $json->errorDescription);
            }

            Log::debug("[ARDOR]: SEND ${method} / ${url}");

        } catch (\GuzzleHttp\Exception\ServerException $ex) {

            Log::error("[ARDOR]: ServerException / ${url}");
            
        } catch (\GuzzleHttp\Exception\ClientException $ex) {

            Log::error("[ARDOR]: ClientException / ${url}");
            
        }

        Cache::store(config('ardor.cache_driver'))->put($id, $json, 60);

        return $json;

    }
    
    /**
     * Send a api request in a chained way
     *
     * @param  mixed $method
     * @param  mixed $body
     * @param  mixed $asAdmin
     * @param  mixed $callback
     * @return void
     */
    public function sendChained(String $method, array $body = [], bool $asAdmin = false, Callable $callback = null) {

        $result = $this->send($method, $body, $asAdmin);
        $this->results[] = $result;

        if (is_callable($callback)){
            $callback($result, sizeOf($this->results) - 1);    
        }

        return $this;
    }
    
    /**
     * Add secret to body
     *
     * @param  mixed $body
     * @param  mixed $secret
     * @return array
     */
    protected function mergeBody(array $body, array $more = [], String $secret = null, bool $requireSecret = true):array {

        $body = array_merge($body, $more);

        if ($requireSecret == true && isset($body['sharedPieceAccount']) == false) {
            $body['secretPhrase'] = $secret !== null ? $secret : config('ardor.secret');
        }

        return $body;
    }

}