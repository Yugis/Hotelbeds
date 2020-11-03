<?php

namespace App\Controllers;

use \App\Models\UserModel;

class Users extends BaseController
{

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index($id)
    {
        //
    }

    public function show($id)
    {
        $user = $this->userModel->find($id);
        die(json_encode($user));
    }

    public function hotelbeds()
    {
        $data = '90db028cc44d811176332c7a14c6f08c' . 'cdf6bd90e0' . time();
        $hash = hash('sha256', $data);
        // die(json_encode($hash));
        $options = [
            'baseURI' => 'https://api.test.hotelbeds.com',
            'headers' => [
                'Api-key'       => '90db028cc44d811176332c7a14c6f08c',
                'Accept'        => 'application/json',
                'X-Signature'   => $hash
            ],
            'http_errors' => false
        ];

        $client = \Config\Services::curlrequest($options);

        $response = $client->request('GET', '/hotel-api/1.0/status');

        echo $response->getStatusCode();
        echo "\n";
        echo $response->getBody();
    }
}
