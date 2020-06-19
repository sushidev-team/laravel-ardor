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

    public function __construct(ArdorNode $node = null, \GuzzleHttp\Client $client = null){
        $this->node = $node != null ? $node : new ArdorNode();
        $this->client = $client != null ? $client : new Client();
    }

    /**
     * Reset the results recieved by the api
     */
    public function reset() {
        $this->results = [];
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

    public function send(String $method, array $body = [], bool $asAdmin = false): object{

        $json = (object) [];
        $url = $this->url($method);

        try {

            if ($asAdmin === true) {
                $body['adminPassword'] = config('ardor.adminPassword');
            }

            $response = $this->client->request("POST", $url, [
                'headers' => [],
                'json' => $body
            ]);

            $json = $response === null ? null : json_decode($response->getBody());

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