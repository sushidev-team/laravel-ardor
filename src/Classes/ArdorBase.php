<?php 

namespace AMBERSIVE\Ardor\Classes;

use Log;

use AMBERSIVE\Ardor\Models\ArdorNode;

use GuzzleHttp\Exception\GuzzleException;
use \GuzzleHttp\Client;

class ArdorBase {

    public ArdorNode $node;
    public Client $client;
    public array  $results = [];
    public int $fee = 0;
    public int $overPayFactor = 1;
    public int $chain = 2;
    public bool $shouldCalculateFee = false;

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
    public function calcFee(int $overPayFactor = 1): ArdorBase {
        $this->shouldCalculateFee = true;
        $this->overPayFactor = $overPayFactor;
        return $this;
    }
    
    /**
     * Set the fee for a command
     *
     * @param  mixed $overPayFactor
     * @return ArdorBase
     */
    public function setFee(int $overPayFactor = 1): ArdorBase {
        $this->overPayFactor = $overPayFactor;
        return $this;
    }

    /**
     * Returns the calcualted fee
     */
    public function getFee(int $overPayFactor = null): int {
        return $this->fee * ($overPayFactor != null ? $overPayFactor : $this->overPayFactor);
    }

    /**
     * Reset the results recieved by the api
     */
    public function reset() {
        $this->results = [];
        $this->fee = 0;
        return $this;
    }
    
    /**
     * Returns an array of api results
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
    public function setClient(\GuzzleHttp\Client $client) {
        $this->client = $client;
        return $this;
    }

    /**
     * Switch the ardor node on the fly
     */
    public function setNode(ArdorNode $node = null) {
        $this->node = $node != null ? $node : new ArdorNode();
        return $this;
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



    public function send(String $method, array $body = [], bool $asAdmin = false, $type = 'json'): object{

        $json = (object) [];
        $url = $this->url($method);

        try {

            if ($asAdmin === true) {
                $body['adminPassword'] = config('ardor.adminPassword');
            }

            if ($this->shouldCalculateFee === true) {
                $body["broadcast"] = false;
            }
            else {
                $body["broadcast"] = true;
                $body["feeNQT"] = $this->getFee();
            }

            $response = $this->client->request("POST", $url, [
                'headers' => [],
                "${type}" => $body
            ]);

            $json = $response === null ? null : json_decode($response->getBody());

            if ($this->shouldCalculateFee === true && isset($json->transactionJSON) && isset($json->transactionJSON->feeNQT)) {
                
                $this->fee = $json->transactionJSON->feeNQT;
                $this->shouldCalculateFee = false;
                $json = $this->send($method, $body, $asAdmin, $type);

            }

        } catch (\GuzzleHttp\Exception\ServerException $ex) {

            Log::error("[ARDOR]: ServerException / ${url}");
            
        } catch (\GuzzleHttp\Exception\ClientException $ex) {

            Log::error("[ARDOR]: ClientException / ${url}");
            
        }

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

}