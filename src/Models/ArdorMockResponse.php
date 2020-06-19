<?php

namespace AMBERSIVE\Ardor\Models;

use GuzzleHttp\Psr7\Response;
 
class ArdorMockResponse {

   public int $status = 200;
   public array $headers = [];
   public $body;

   public function __construct(int $status, $body = [], $headers = []){
       $this->status   = $status;
       $this->headers = $headers;
       $this->body    = $body;
   }

   public function get(): Response{
      return new Response($this->status, $this->headers, json_encode($this->body));
   }

}