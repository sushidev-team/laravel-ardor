<?php 

namespace AMBERSIVE\Ardor\Classes;

use Log;

use AMBERSIVE\Ardor\Models\ArdorNode;

use GuzzleHttp\Exception\GuzzleException;
use \GuzzleHttp\Client;

class ArdorBase {

    public ArdorNode $node;
    public Client $client;

    public function __construct(ArdorNode $node = null, \GuzzleHttp\Client $client = null){
        $this->node = $node != null ? $node : new ArdorNode();
        $this->client = $client != null ? $client : new Client();
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

    public function send(String $method, array $body = []): object{

        $json = (object) [];
        $url = $this->url($method);

        try {

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

}