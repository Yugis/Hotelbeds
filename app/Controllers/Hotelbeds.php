<?php

namespace App\Controllers;

use \App\Models\StateModel;
use \App\Models\DestinationModel;
use \App\Models\AccommodationModel;
use \App\Models\BoardModel;
use \App\Models\CategoryModel;
use \App\Models\ChainModel;
use \App\Models\CurrencyModel;
use \App\Models\FacilityModel;
use \App\Models\FacilityGroupModel;

class Hotelbeds extends BaseController
{
    public function __construct()
    {
        $this->stateModel = new StateModel();
        $this->destinationModel = new DestinationModel();
        $this->accommodationModel = new AccommodationModel();
        $this->boardModel = new BoardModel();
        $this->categoryModel = new CategoryModel();
        $this->chainModel = new ChainModel();
        $this->currencyModel = new CurrencyModel();
        $this->facilityModel = new FacilityModel();
        $this->facilityGroupModel = new FacilityGroupModel();

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
            'http_errors' => false
        ];
    }

    public function status()
    {
        $client = \Config\Services::curlrequest($this->options);

        $response = $client->request('GET', '/hotel-api/1.0/status');

        echo $response->getStatusCode();
        echo "\n";
        echo $response->getBody();
    }

    public function getStates()
    {
        $client = \Config\Services::curlrequest($this->options);
        $response = $client->request('GET', '/hotel-content-api/1.0/locations/countries?fields=all&language=ENG&from=1&to=207');

        $countries = (array) json_decode($response->getBody())->countries;

        foreach ($countries as $country) {
            foreach ($country->states as $state) {
                $data[] = [
                    'country_code' => $country->code,
                    'country_iso_code' => $country->isoCode,
                    'country_name' => $country->description->content,
                    'code' => $state->code,
                    'name' => $state->name
                ];
            }
        }
        // $this->stateModel->insertBatch($data);
        print_r(json_encode($data));
        die('Success!');
    }

    public function getDestinations()
    {
        $client = \Config\Services::curlrequest($this->options);
        for ($for = 1, $to = 1000, $for <= 6000; $to <= 6000;) {
            $response = $client->request('GET', '/hotel-content-api/1.0/locations/destinations?fields=all&language=ENG&from=' . $for . '&to=' . $to . '');

            $destinations = (array) json_decode($response->getBody())->destinations;

            foreach ($destinations as $destination) {
                foreach ($destination->zones as $zone) {
                    $data[] = [
                        'destination_code' => $destination->code,
                        'destination_name' => $destination->name->content,
                        'country_iso_code' => $destination->isoCode,
                        'country_code' => $destination->countryCode,
                        'zone_code' => $zone->zoneCode,
                        'zone_name' => $zone->name,
                        'zone_description' => $zone->description->content ?? 'null'
                    ];
                }
            }
            $for = $for + 1000;
            $to = $to + 1000;
        }
        // $this->destinationModel->insertBatch($data);
        print_r(json_encode($data));
        die('Success!');
    }

    public function getAccomodations()
    {
        $client = \Config\Services::curlrequest($this->options);
        $response = $client->request('GET', '/hotel-content-api/1.0/types/accommodations?fields=all&language=ENG&from=1&to=100');

        $accommodations = (array) json_decode($response->getBody())->accommodations;

        foreach ($accommodations as $accommodation) {
            $data[] = [
                'code' => $accommodation->code,
                'description' => $accommodation->typeMultiDescription->content,
            ];
        }
        // $this->accommodationModel->insertBatch($data);
        print_r(json_encode($data));
        die('Success!');
    }

    public function getBoards()
    {
        $client = \Config\Services::curlrequest($this->options);
        $response = $client->request('GET', '/hotel-content-api/1.0/types/boards?fields=all&language=ENG&from=1&to=100');

        $boards = (array) json_decode($response->getBody())->boards;

        foreach ($boards as $board) {
            $data[] = [
                'code' => $board->code,
                'description' => $board->description->content,
            ];
        }
        // $this->boardModel->insertBatch($data);
        print_r(json_encode($data));
        die('Success!');
    }

    public function getCategories()
    {
        $client = \Config\Services::curlrequest($this->options);
        $response = $client->request('GET', '/hotel-content-api/1.0/types/categories?fields=all&language=ENG&from=1&to=100');

        $categories = (array) json_decode($response->getBody())->categories;

        foreach ($categories as $category) {
            $data[] = [
                'code' => $category->code,
                'simple_code' => $category->simpleCode,
                'accommodation_type' => $category->accommodationType,
                'group' => $category->group ?? 'null',
                'description' => $category->description->content,
            ];
        }
        // $this->categoryModel->insertBatch($data);
        print_r(json_encode($data));
        die('Success!');
    }

    public function getChains()
    {
        $client = \Config\Services::curlrequest($this->options);
        for ($for = 1, $to = 1000, $for <= 3000; $to <= 3000;) {
            $response = $client->request('GET', '/hotel-content-api/1.0/types/chains?fields=all&language=ENG&from=' . $for . '&to=' . $to . '');

            $chains = (array) json_decode($response->getBody())->chains;

            foreach ($chains as $chain) {
                $data[] = [
                    'code' => $chain->code,
                    'description' => $chain->description->content ?? 'null',
                ];
            }
            $for = $for + 1000;
            $to = $to + 1000;
        }
        // $this->chainModel->insertBatch($data);
        print_r(json_encode($data));
        die('Success!');
    }

    public function getCurrencies()
    {
        $client = \Config\Services::curlrequest($this->options);
        $response = $client->request('GET', '/hotel-content-api/1.0/types/currencies?fields=all&language=ENG&from=1&to=200');

        $currencies = (array) json_decode($response->getBody())->currencies;

        foreach ($currencies as $currency) {
            $data[] = [
                'code' => $currency->code,
                'description' => $currency->description->content,
                'type' => $currency->currencyType,
            ];
        }
        // $this->currencyModel->insertBatch($data);
        print_r(json_encode($data));
        die('Success!');
    }

    public function getFacilities()
    {
        $client = \Config\Services::curlrequest($this->options);
        $response = $client->request('GET', '/hotel-content-api/1.0/types/facilities?fields=all&language=ENG&from=1&to=600');

        $facilities = (array) json_decode($response->getBody())->facilities;

        foreach ($facilities as $facility) {
            $data[] = [
                'code' => $facility->code,
                'group_code' => $facility->facilityGroupCode,
                'typology_code' => $facility->facilityTypologyCode,
                'description' => $facility->description->content ?? 'null',
            ];
        }
        // $this->facilityModel->insertBatch($data);
        print_r(json_encode($data));
        die('Success!');
    }

    public function getFacilityGroups()
    {
        $client = \Config\Services::curlrequest($this->options);
        $response = $client->request('GET', '/hotel-content-api/1.0/types/facilitygroups?fields=all&language=ENG&from=1&to=100');

        $facilityGroups = (array) json_decode($response->getBody())->facilityGroups;

        foreach ($facilityGroups as $facilityGroup) {
            $data[] = [
                'code' => $facilityGroup->code,
                'description' => $facilityGroup->description->content ?? 'null',
            ];
        }
        $this->facilityGroupModel->insertBatch($data);
        print_r(json_encode($data));
        die('Success!');
    }
}
