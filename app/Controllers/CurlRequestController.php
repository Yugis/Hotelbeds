<?php

namespace App\Controllers;

class CurlRequestController
{

    public function __construct()
    {
        $this->hash = hash('sha256', '90db028cc44d811176332c7a14c6f08c' . 'cdf6bd90e0' . time());
        $this->base_uri = 'https://api.test.hotelbeds.com';
        $this->headers = [
            'Api-key'       => '90db028cc44d811176332c7a14c6f08c',
            'Accept'        => 'application/json',
            'X-Signature'   => $this->hash
        ];
        $this->options = [
            'baseURI' => $this->base_uri,
            'headers' => $this->headers,
            'http_errors' => true
        ];
        $this->client = \Config\Services::curlrequest($this->options);
    }
}
