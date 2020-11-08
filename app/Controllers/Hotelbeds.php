<?php

namespace App\Controllers;

use \App\Models\{
    StateModel,
    DestinationModel,
    AccommodationModel,
    BoardModel,
    CategoryModel,
    ChainModel,
    CurrencyModel,
    FacilityModel,
    FacilityGroupModel,
    FacilityTypologyModel,
    IssueModel,
    LanguageModel,
    PromotionModel,
    RoomModel,
    SegmentModel,
    TerminalModel,
    ImageTypeModel,
    GroupCategoryModel
};

class Hotelbeds extends BaseController
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
            'http_errors' => false
        ];
        $this->client = \Config\Services::curlrequest($this->options);
    }

    public function status()
    {
        $response = $this->client->request('GET', '/hotel-api/1.0/status');

        echo $response->getStatusCode();
        echo "\n";
        echo $response->getBody();
    }

    public function getStates()
    {
        $response = $this->client->request('GET', '/hotel-content-api/1.0/locations/countries?fields=all&language=ENG&from=1&to=207');

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
        $stateModel = new StateModel();
        // $stateModel->insertBatch($data);
        print_r(json_encode($data));
        die('Success!');
    }

    public function getDestinations()
    {
        for ($for = 1, $to = 1000, $for <= 6000; $to <= 6000;) {
            $response = $this->client->request('GET', '/hotel-content-api/1.0/locations/destinations?fields=all&language=ENG&from=' . $for . '&to=' . $to . '');

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
        $destinationModel = new DestinationModel();
        // $destinationModel->insertBatch($data);
        print_r(json_encode($data));
        die('Success!');
    }

    public function getAccomodations()
    {
        $response = $this->client->request('GET', '/hotel-content-api/1.0/types/accommodations?fields=all&language=ENG&from=1&to=100');

        $accommodations = (array) json_decode($response->getBody())->accommodations;

        foreach ($accommodations as $accommodation) {
            $data[] = [
                'code' => $accommodation->code,
                'description' => $accommodation->typeMultiDescription->content,
            ];
        }
        $accommodationModel = new AccommodationModel();
        // $accommodationModel->insertBatch($data);
        print_r(json_encode($data));
        die('Success!');
    }

    public function getBoards()
    {
        $response = $this->client->request('GET', '/hotel-content-api/1.0/types/boards?fields=all&language=ENG&from=1&to=100');

        $boards = (array) json_decode($response->getBody())->boards;

        foreach ($boards as $board) {
            $data[] = [
                'code' => $board->code,
                'description' => $board->description->content,
            ];
        }
        $boardModel = new BoardModel();
        // $boardModel->insertBatch($data);
        print_r(json_encode($data));
        echo "<br>";
        die('Success!');
    }

    public function getCategories()
    {
        $response = $this->client->request('GET', '/hotel-content-api/1.0/types/categories?fields=all&language=ENG&from=1&to=100');

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
        $categoryModel = new CategoryModel();
        // $categoryModel->insertBatch($data);
        print_r(json_encode($data));
        die('Success!');
    }

    public function getChains()
    {
        for ($for = 1, $to = 1000, $for <= 3000; $to <= 3000;) {
            $response = $this->client->request('GET', '/hotel-content-api/1.0/types/chains?fields=all&language=ENG&from=' . $for . '&to=' . $to . '');

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
        $chainModel = new ChainModel();
        // $chainModel->insertBatch($data);
        print_r(json_encode($data));
        die('Success!');
    }

    public function getCurrencies()
    {
        $response = $this->client->request('GET', '/hotel-content-api/1.0/types/currencies?fields=all&language=ENG&from=1&to=200');

        $currencies = (array) json_decode($response->getBody())->currencies;

        foreach ($currencies as $currency) {
            $data[] = [
                'code' => $currency->code,
                'description' => $currency->description->content,
                'type' => $currency->currencyType,
            ];
        }
        $currencyModel = new CurrencyModel();
        // $currencyModel->insertBatch($data);
        print_r(json_encode($data));
        die('Success!');
    }

    public function getFacilities()
    {
        $response = $this->client->request('GET', '/hotel-content-api/1.0/types/facilities?fields=all&language=ENG&from=1&to=600');

        $facilities = (array) json_decode($response->getBody())->facilities;

        foreach ($facilities as $facility) {
            $data[] = [
                'code' => $facility->code,
                'group_code' => $facility->facilityGroupCode,
                'typology_code' => $facility->facilityTypologyCode,
                'description' => $facility->description->content ?? 'null',
            ];
        }
        $facilityModel = new FacilityModel();
        // $facilityModel->insertBatch($data);
        print_r(json_encode($data));
        die('Success!');
    }

    public function getFacilityGroups()
    {
        $response = $this->client->request('GET', '/hotel-content-api/1.0/types/facilitygroups?fields=all&language=ENG&from=1&to=100');

        $facilityGroups = (array) json_decode($response->getBody())->facilityGroups;

        foreach ($facilityGroups as $facilityGroup) {
            $data[] = [
                'code' => $facilityGroup->code,
                'description' => $facilityGroup->description->content ?? 'null',
            ];
        }
        $facilityGroupModel = new FacilityGroupModel();
        // $facilityGroupModel->insertBatch($data);
        print_r(json_encode($data));
        echo "<br>";
        die('Success!');
    }

    public function getFacilityTypologies()
    {
        $response = $this->client->request('GET', '/hotel-content-api/1.0/types/facilitytypologies?fields=all&language=ENG&from=1&to=100');

        $facilityTypologies = (array) json_decode($response->getBody())->facilityTypologies;

        foreach ($facilityTypologies as $typology) {
            $data[] = [
                'code' => $typology->code,
                'number_flag' => $typology->numberFlag,
                'logic_flag' => $typology->logicFlag,
                'fee_flag' => $typology->feeFlag,
                'distance_flag' => $typology->distanceFlag,
                'age_from_flag' => $typology->ageFromFlag,
                'age_to_flag' => $typology->ageToFlag,
                'date_from_flag' => $typology->dateFromFlag,
                'date_to_flag' => $typology->dateToFlag,
                'time_from_flag' => $typology->timeFromFlag,
                'time_to_flag' => $typology->timeToFlag,
                'ind_yes_or_no_flag' => $typology->indYesOrNoFlag,
                'amount_flag' => $typology->amountFlag,
                'currency_flag' => $typology->currencyFlag,
                'app_type_flag' => $typology->appTypeFlag,
                'text_flag' => $typology->textFlag
            ];
        }
        $facilityTypologyModel = new FacilityTypologyModel();
        // $facilityTypologyModel->insertBatch($data);
        print_r(json_encode($data));
        echo "<br>";
        die('Success!');
    }

    public function getIssues()
    {
        $response = $this->client->request('GET', '/hotel-content-api/1.0/types/issues?fields=all&language=ENG&from=1&to=100');

        $issues = (array) json_decode($response->getBody())->issues;

        foreach ($issues as $issue) {
            $data[] = [
                'code' => $issue->code,
                'type' => $issue->type,
                'description' => $issue->description->content ?? 'null',
                'name' => $issue->name->content ?? 'null',
                'alternative' => $issue->alternative
            ];
        }
        $issueModel = new IssueModel();
        // $issueModel->insertBatch($data);
        // print_r(json_encode($data));
        echo "<br>";
        die('Success!');
    }

    public function getLanguages()
    {
        $response = $this->client->request('GET', '/hotel-content-api/1.0/types/languages?fields=all&language=ENG&from=1&to=100');

        $languages = (array) json_decode($response->getBody())->languages;

        foreach ($languages as $language) {
            $data[] = [
                'code' => $language->code,
                'name' => $language->name ?? 'null',
                'description' => $language->description->content
            ];
        }
        $languageModel = new LanguageModel();
        // $languageModel->insertBatch($data);
        print_r(json_encode($data));
        echo "<br>";
        die('Success!');
    }

    public function getPromotions()
    {
        $response = $this->client->request('GET', '/hotel-content-api/1.0/types/promotions?fields=all&language=ENG&from=1&to=200');

        $promotions = (array) json_decode($response->getBody())->promotions;

        foreach ($promotions as $promotion) {
            $data[] = [
                'code' => $promotion->code,
                'name' => $promotion->name->content ?? 'null',
                'description' => $promotion->description->content ?? 'null'
            ];
        }
        $promotionModel = new PromotionModel();
        // $promotionModel->insertBatch($data);
        print_r(json_encode($data));
        echo "<br>";
        die('Success!');
    }

    public function getRooms()
    {
        for ($for = 1, $to = 1000, $for <= 9900; $to <= 9900;) {
            $response = $this->client->request('GET', '/hotel-content-api/1.0/types/rooms?fields=all&language=ENG&from=' . $for . '&to=' . $to . '');
            $rooms = (array) json_decode($response->getBody())->rooms;

            foreach ($rooms as $room) {
                $data[] = [
                    'code' => $room->code,
                    'type' => $room->type,
                    'characteristic' => $room->characteristic,
                    'min_pax' => $room->minPax,
                    'max_pax' => $room->maxPax,
                    'max_adults' => $room->maxAdults,
                    'max_children' => $room->maxChildren,
                    'min_adults' => $room->minAdults,
                    'description' => $room->description ?? 'null',
                    'type_description' => $room->typeDescription->content,
                    'characteristic_description' => $room->characteristicDescription->content ?? 'null',
                ];
            }
        }
        $roomModel = new RoomModel();
        // $roomModel->insertBatch($data);
        // print_r(json_encode($data));
        echo "<br>";
        die('Success!');
    }

    public function getSegments()
    {
        $response = $this->client->request('GET', '/hotel-content-api/1.0/types/segments?fields=all&language=ENG&from=1&to=100');

        $segments = (array) json_decode($response->getBody())->segments;

        foreach ($segments as $segments) {
            $data[] = [
                'code' => $segments->code,
                'description' => $segments->description->content
            ];
        }
        $segmentModel = new SegmentModel();
        // $segmentModel->insertBatch($data);
        print_r(json_encode($data));
        echo "<br>";
        die('Success!');
    }

    public function getTerminals()
    {
        for ($for = 1, $to = 1000, $for <= 2000; $to <= 2000;) {
            $response = $this->client->request('GET', '/hotel-content-api/1.0/types/terminals?fields=all&language=ENG&from=' . $for . '&to=' . $to . '');

            $terminals = (array) json_decode($response->getBody())->terminals;

            foreach ($terminals as $terminal) {
                $data[] = [
                    'code' => $terminal->code,
                    'type' => $terminal->type,
                    'country' => $terminal->country,
                    'name' => $terminal->name->content,
                    'description' => $terminal->description->content,
                ];
            }
            $for = $for + 1000;
            $to = $to + 1000;
        }
        $terminalModel = new TerminalModel();
        // $terminalModel->insertBatch($data);
        // print_r(json_encode($data));
        die('Success!');
    }

    public function getImageTypes()
    {
        $response = $this->client->request('GET', '/hotel-content-api/1.0/types/imagetypes?fields=all&language=ENG&from=1&to=100');

        $imageTypes = (array) json_decode($response->getBody())->imageTypes;

        foreach ($imageTypes as $type) {
            $data[] = [
                'code' => $type->code,
                'description' => $type->description->content
            ];
        }
        $imageTypeModel = new ImageTypeModel();
        // $imageTypeModel->insertBatch($data);
        print_r(json_encode($data));
        echo "<br>";
        die('Success!');
    }

    public function getGroupCategories()
    {
        $response = $this->client->request('GET', '/hotel-content-api/1.0/types/groupcategories?fields=all&language=ENG&from=1&to=100');

        $groupCategories = (array) json_decode($response->getBody())->groupCategories;

        foreach ($groupCategories as $groupCategory) {
            $data[] = [
                'code' => $groupCategory->code,
                'order' => $groupCategory->order,
                'description' => $groupCategory->description->content
            ];
        }
        $groupCategoryModel = new GroupCategoryModel();
        // $groupCategoryModel->insertBatch($data);
        print_r(json_encode($data));
        echo "<br>";
        die('Success!');
    }
}
