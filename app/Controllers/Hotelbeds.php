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
    GroupCategoryModel,
    HotelModel,
};
use Config\App;
use Exception;

class Hotelbeds extends BaseController
{
    public function __construct()
    {
        $this->hash = hash('sha256', '90db028cc44d811176332c7a14c6f08c' . 'cdf6bd90e0' . $this->time = time());
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
        for ($for = 1, $to = 1000, $for <= 11000; $to <= 11000;) {
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
                    'description' => $room->description ?? null,
                    'type_description' => $room->typeDescription->content,
                    'characteristic_description' => $room->characteristicDescription->content ?? null,
                ];
            }
            $for += 1000;
            $to += 1000;
        }
        $roomModel = new RoomModel();
        $roomModel->insertBatch($data);
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

    // public function getHotels()
    // {
    //     $response = $this->client->request('GET', '/hotel-content-api/1.0/hotels?fields=all&language=ENG&useSecondaryLanguage=false&from=1&to=100');

    //     $hotels = (array) json_decode($response->getBody())->hotels;

    //     foreach ($hotels as $hotel) {
    //         // die(json_encode($hotel));
    //         $data[] = [
    //             'code' => $hotel->code,
    //             'name' => $hotel->name->content,
    //             'description' => $hotel->description->content,
    //             'country_code' => $hotel->countryCode,
    //             'state_code' => $hotel->stateCode,
    //             'destination_code' => $hotel->destinationCode,
    //             'zone_code' => $hotel->zoneCode,
    //             'longitude' => $hotel->coordinates->longitude,
    //             'latitude' => $hotel->coordinates->latitude,
    //             'category_code' => $hotel->categoryCode,
    //             'category_group_code' => $hotel->categoryGroupCode,
    //             'chain_code' => $hotel->chainCode ?? null,
    //             'accommodation_type_code' => $hotel->accommodationTypeCode,
    //             'address' => $hotel->address->content,
    //             'postal_code' => $hotel->postalCode,
    //             'city' => $hotel->city->content,
    //             'email' => $hotel->email ?? null,
    //             'license' => $hotel->license ?? null,
    //             'web' => $hotel->web ?? null,
    //             'last_update' => $hotel->lastUpdate,
    //             'S2C' => $hotel->S2C ?? null,
    //             'ranking' => $hotel->ranking,
    //         ];

    //         foreach ($hotel->boardCodes as $board) {
    //             if ($board == null) {
    //                 continue;
    //             }
    //             $hotelBoardsData[] = [
    //                 'hotel_code' => $hotel->code,
    //                 'board_code' => $board
    //             ];
    //         }

    //         foreach ($hotel->segmentCodes as $segment) {
    //             $hotelSegmentsData[] = [
    //                 'hotel_code' => $hotel->code,
    //                 'segment_code' => $segment
    //             ];
    //         }

    //         foreach ($hotel->phones as $phone) {
    //             $phonesData[] = [
    //                 'hotel_code' => $hotel->code,
    //                 'phone_number' => $phone->phoneNumber,
    //                 'phone_type' => $phone->phoneType
    //             ];
    //         }

    //         foreach ($hotel->rooms as $room) {
    //             $roomsData[] = [
    //                 'hotel_code' => $hotel->code,
    //                 'room_code' => $room->roomCode
    //             ];

    //             if (isset($room->roomFacilities)) {
    //                 foreach ($room->roomFacilities as $roomFacility) {
    //                     $roomFacilitiesData[] = [
    //                         'hotel_code' => $hotel->code,
    //                         'room_code' => $room->roomCode,
    //                         'facility_code' => $roomFacility->facilityCode,
    //                         'facility_group_code' => $roomFacility->facilityGroupCode,
    //                         'ind_fee' => $roomFacility->indFee ?? null,
    //                         'ind_logic' => $roomFacility->indLogic ?? null,
    //                         'ind_yes_no' => $roomFacility->indYesOrNo ?? null,
    //                         'number' => $roomFacility->number ?? null,
    //                         'order' => $roomFacility->order ?? null,
    //                         'voucher' => $roomFacility->voucher ?? null,
    //                     ];
    //                 }
    //             }

    //             if (isset($room->roomStays)) {
    //                 foreach ($room->roomStays as $roomStay) {
    //                     $roomStaysData[] = [
    //                         'hotel_code' => $hotel->code,
    //                         'room_code' => $room->roomCode,
    //                         'stay_type' => $roomStay->stayType,
    //                         'description' => $roomStay->description ?? null,
    //                         'order' => $roomStay->order
    //                     ];

    //                     // if (isset($roomStay->roomStayFacilities)) {
    //                     //     foreach ($roomStay->roomStayFacilities as $roomStayFacility) {
    //                     //         $roomStayFacilitiesData[] = [
    //                     //             'hotel_code' => $hotel->code,
    //                     //             'room_code' => $room->roomCode,
    //                     //             'room_stay_type' => $roomStay->stayType,
    //                     //             'facility_code' => $roomStayFacility->facilityCode,
    //                     //             'facility_group_code' => $roomStayFacility->facilityGroupCode,
    //                     //             'number' => $roomStayFacility->number,
    //                     //         ];
    //                     //     }
    //                     // }
    //                 }
    //             }
    //         }

    //         foreach ($hotel->facilities as $facility) {
    //             $facilitiesData[] = [
    //                 'hotel_code' => $hotel->code,
    //                 'facility_code' => $facility->facilityCode,
    //                 'facility_group_code' => $facility->facilityGroupCode,
    //                 'order' => $facility->order ?? null,
    //                 'number' => $facility->number ?? null,
    //                 'voucher' => $facility->voucher ?? null,
    //                 'ind_yes_no' => $facility->indYesOrNo ?? null,
    //                 'ind_logic' => $facility->indLogic ?? null,
    //                 'ind_fee' => $facility->indFee ?? null,
    //                 'distance' => $facility->distance ?? null,
    //                 'time_from' => $facility->timeFrom ?? null,
    //                 'time_to' => $facility->timeTo ?? null,
    //                 'date_from' => $facility->dateFrom ?? null,
    //                 'date_to' => $facility->dateTo ?? null,
    //                 'age_from' => $facility->ageFrom ?? null,
    //                 'age_to' => $facility->ageTo ?? null,
    //                 'currency' => $facility->currency ?? null,
    //                 'amount' => $facility->amount ?? null,
    //                 'application_type' => $facility->applicationType ?? null,
    //             ];
    //         }

    //         if (isset($hotel->terminals)) {
    //             foreach ($hotel->terminals as $terminal) {
    //                 $terminalsData[] = [
    //                     'hotel_code' => $hotel->code,
    //                     'terminal_code' => $terminal->terminalCode,
    //                     'distance' => $terminal->distance
    //                 ];
    //             }
    //         }

    //         if (isset($hotel->issues)) {
    //             foreach ($hotel->issues as $issue) {
    //                 $issuesData[] = [
    //                     'hotel_code' => $hotel->code,
    //                     'issue_code' => $issue->issueCode,
    //                     'issue_type' => $issue->issueType,
    //                     'date_from' => $issue->dateFrom,
    //                     'date_to' => $issue->dateTo,
    //                     'order' => $issue->order,
    //                     'alternative' => $issue->alternative,
    //                 ];
    //             }
    //         }

    //         foreach ($hotel->images as $image) {
    //             $imagesData[] = [
    //                 'hotel_code' => $hotel->code,
    //                 'image_type_code' => $image->imageTypeCode,
    //                 'path' => $image->path,
    //                 'order' => $image->order,
    //                 'visual_order' => $image->visualOrder,
    //                 'room_code' => $image->roomCode ?? null,
    //                 'room_type' => $image->roomType ?? null,
    //                 'characteristic_code' => $image->characteristicCode ?? null,
    //             ];
    //         }

    //         if (isset($hotel->wildcards)) {
    //             foreach ($hotel->wildcards as $wildcard) {
    //                 $wildcardsData[] = [
    //                     'hotel_code' => $hotel->code,
    //                     'room_code' => $wildcard->roomType,
    //                     'room_type' => $wildcard->roomCode,
    //                     'characteristic_code' => $wildcard->characteristicCode,
    //                     'hotel_room_description' => $wildcard->hotelRoomDescription->content,
    //                 ];
    //             }
    //         }
    //     }
    //     die(json_encode($imagesData));
    //     $db      = \Config\Database::connect();

    //     // $hotelModel = new HotelModel();
    //     // $hotelModel->insertBatch($data);

    //     // $hotelBoards = $db->table('hotels_boards');
    //     // $hotelBoards->insertBatch($hotelBoardsData);

    //     // $hotelSegments = $db->table('hotels_segments');
    //     // $hotelSegments->insertBatch($hotelSegmentsData);

    //     // $phones = $db->table('phones');
    //     // $phones->insertBatch($phonesData);

    //     // $hotelRooms = $db->table('hotels_rooms');
    //     // $hotelRooms->insertBatch($roomsData);

    //     // $roomFacilities = $db->table('rooms_facilities');
    //     // $roomFacilities->insertBatch($roomFacilitiesData);

    //     // $roomStays = $db->table('room_stays');
    //     // $roomStays->insertBatch($roomStaysData);

    //     // $roomStayFacilities = $db->table('room_stay_facilities');
    //     // $roomStayFacilities->insertBatch($roomStayFacilitiesData);

    //     // $hotelFacilities = $db->table('hotels_facilities');
    //     // $hotelFacilities->insertBatch($facilitiesData);

    //     // $hotelTerminals = $db->table('hotels_terminals');
    //     // $hotelTerminals->insertBatch($terminalsData);

    //     // $hotelIssues = $db->table('hotels_issues');
    //     // $hotelIssues->insertBatch($issuesData);

    //     $hotelImages = $db->table('hotels_images');
    //     $hotelImages->insertBatch($imagesData);

    //     // $hotelWildcards = $db->table('hotels_wildcards');
    //     // $hotelWildcards->insertBatch($wildcardsData);

    //     print_r(json_encode($data));
    //     echo "<br>";
    //     echo "<br>";
    //     die('Success!');
    // }

    // public function fetchHotels()
    // {
    //     $base_uri = 'https://api.test.hotelbeds.com';
    //     // $q = new CurlRequestController();
    //     for ($from = 1, $to = 1000, $from <= 180000; $to <= 180000;) {
    //         echo 'inside fetchHotels';
    //         echo "<br>";
    //         echo (memory_get_usage(true) / 1024 / 1024) . 'MB';
    //         echo "<br>";

    //         // unset($hash);
    //         // $hash = hash('sha256', '90db028cc44d811176332c7a14c6f08c' . 'cdf6bd90e0' . $time = time());
    //         echo 'time is ' . date('h:i:s A', $this->time);
    //         echo "<br>";
    //         // $headers = null;
    //         // $headers = [
    //         //     'Api-key'       => '90db028cc44d811176332c7a14c6f08c',
    //         //     'Accept'        => 'application/json',
    //         //     'X-Signature'   => $hash
    //         // ];
    //         // $options = null;
    //         // $options = [
    //         //     'baseURI' => $base_uri,
    //         //     'headers' => $headers,
    //         //     'http_errors' => false
    //         // ];
    //         // unset($client);
    //         // $client = null;
    //         // $client = \Config\Services::curlrequest($options);
    //         // $client = new CurlRequestController();
    //         echo 'hash ' . $this->hash;
    //         // echo "<br>";
    //         $response = null;
    //         $response = $this->client->request('GET', '/hotel-content-api/1.0/hotels?fields=all&language=ENG&useSecondaryLanguage=false&from=' . $from . '&to=' . $to . '');

    //         $hotels = null;

    //         // try {
    //         $hotels = (array) json_decode($response->getBody())->hotels;
    //         // } catch (\Exception $e) {
    //         //     echo $e->getMessage();
    //         //     echo "<br>";
    //         //     echo date('h:i:s A', $this->time);
    //         //     echo "<br>";
    //         //     // continue;
    //         //     die(json_encode($e));
    //         // }

    //         $from += 1000;
    //         $to += 1000;
    //         gc_collect_cycles();
    //         yield $hotels;
    //     }
    // }

    // public function testing()
    // {
    //     $q = (new HotelModel())->orderBy('code', 'desc')->first();
    //     die(json_encode($q));
    //     throw new \ErrorException('', 401);
    //     die($this->hash);
    // }

    public function gettingHotels()
    {
        $base_uri = 'https://api.test.hotelbeds.com';
        // $q = new CurlRequestController();
        for ($from = 1, $to = 1000, $from <= 180000; $to <= 180000;) {
            $hash = null;
            $hash = hash('sha256', '90db028cc44d811176332c7a14c6f08c' . 'cdf6bd90e0' . $time = time());
            echo 'inside fetchHotels';
            echo "<br>";
            echo (memory_get_usage(true) / 1024 / 1024) . 'MB';
            echo "<br>";
            echo 'time is ' . date('h:i:s A', $time);
            echo "<br>";
            echo 'hash ' . $hash;
            echo "<br>";
            $headers = null;
            $headers = [
                'Api-key'       => '90db028cc44d811176332c7a14c6f08c',
                'Accept'        => 'application/json',
                'X-Signature'   => $hash
            ];
            $options = null;
            $options = [
                'baseURI' => $base_uri,
                'headers' => $headers,
                'http_errors' => false
            ];
            $client = null;
            $client = \Config\Services::curlrequest($options);
            $response = null;
            $response = $client->request('GET', '/hotel-content-api/1.0/hotels?fields=all&language=ENG&useSecondaryLanguage=false&from=' . $from . '&to=' . $to . '');

            $hotels = null;
            $hotels = (array) json_decode($response->getBody())->hotels;

            $from += 1000;
            $to += 1000;
            gc_collect_cycles();
            $db = null;
            $db = \Config\Database::connect();

            // Skipping current batch of 1000 hotels if the last fetched hotel code is smaller than the last hotel code saved in the db
            $latestHotel = (new HotelModel())->orderBy('code', 'desc')->first();
            if ($latestHotel && end($hotels)->code <= $latestHotel->code) continue;

            $latestHotel = null;
            $data = [];
            foreach ($hotels as $hotel) {
                $data[] = [
                    'code' => $hotel->code,
                    'name' => $hotel->name->content,
                    'description' => $hotel->description->content ?? null,
                    'country_code' => $hotel->countryCode,
                    'state_code' => $hotel->stateCode,
                    'destination_code' => $hotel->destinationCode,
                    'zone_code' => $hotel->zoneCode ?? null,
                    'longitude' => $hotel->coordinates->longitude ?? null,
                    'latitude' => $hotel->coordinates->latitude ?? null,
                    'category_code' => $hotel->categoryCode ?? null,
                    'category_group_code' => $hotel->categoryGroupCode ?? null,
                    'chain_code' => $hotel->chainCode ?? null,
                    'accommodation_type_code' => $hotel->accommodationTypeCode ?? null,
                    'address' => $hotel->address->content,
                    'postal_code' => $hotel->postalCode ?? null,
                    'city' => $hotel->city->content,
                    'email' => $hotel->email ?? null,
                    'license' => $hotel->license ?? null,
                    'web' => $hotel->web ?? null,
                    'last_update' => $hotel->lastUpdate,
                    'S2C' => $hotel->S2C ?? null,
                    'ranking' => $hotel->ranking ?? null,
                ];
            }
            $hotel = null;
            if (count($data)) {
                foreach (array_chunk($data, 1000) as $value) {
                    (new HotelModel())->insertBatch($value);
                }
            }

            $value = null;
            $data = null;

            foreach ($hotels as $hotel) {
                echo 'inside first foreach';
                echo "<br>";
                echo 'hotel code is: ' . $hotel->code;
                echo "<br>";
                echo (memory_get_usage(true) / 1024 / 1024) . 'MB';
                echo "<br>";

                if (isset($hotel->boardCodes)) {
                    foreach ($hotel->boardCodes as $board) {
                        if ($board == null) {
                            continue;
                        }
                        $hotelBoardsData[] = [
                            'hotel_code' => $hotel->code,
                            'board_code' => $board
                        ];
                    }
                }

                foreach ($hotel->segmentCodes as $segment) {
                    $hotelSegmentsData[] = [
                        'hotel_code' => $hotel->code,
                        'segment_code' => $segment
                    ];
                }

                foreach ($hotel->phones as $phone) {
                    $phonesData[] = [
                        'hotel_code' => $hotel->code,
                        'phone_number' => $phone->phoneNumber,
                        'phone_type' => $phone->phoneType
                    ];
                }

                if (isset($hotel->rooms)) {
                    foreach ($hotel->rooms as $room) {
                        $roomsData[] = [
                            'hotel_code' => $hotel->code,
                            'room_code' => $room->roomCode
                        ];

                        if (count($roomsData) >= 1000) {
                            $db->transStart();
                            foreach (array_chunk($roomsData, 1000) as $value) {
                                $db->table('hotels_rooms')->insertBatch($value);
                            }
                            $roomsData = null;
                            $db->transComplete();
                        }

                        if (isset($room->roomFacilities)) {
                            foreach ($room->roomFacilities as $roomFacility) {
                                $roomFacilitiesData[] = [
                                    'hotel_code' => $hotel->code,
                                    'room_code' => $room->roomCode,
                                    'facility_code' => $roomFacility->facilityCode,
                                    'facility_group_code' => $roomFacility->facilityGroupCode,
                                    'ind_fee' => $roomFacility->indFee ?? null,
                                    'ind_logic' => $roomFacility->indLogic ?? null,
                                    'ind_yes_no' => $roomFacility->indYesOrNo ?? null,
                                    'number' => $roomFacility->number ?? null,
                                    'order' => $roomFacility->order ?? null,
                                    'voucher' => $roomFacility->voucher ?? null,
                                ];
                            }

                            if (count($roomFacilitiesData) >= 1000) {
                                $db->transStart();
                                foreach (array_chunk($roomFacilitiesData, 1000) as $value) {
                                    $db->table('rooms_facilities')->insertBatch($value);
                                }
                                $roomFacilitiesData = null;
                                $db->transComplete();
                            }
                        }

                        if (isset($room->roomStays)) {
                            foreach ($room->roomStays as $roomStay) {
                                $roomStaysData[] = [
                                    'hotel_code' => $hotel->code,
                                    'room_code' => $room->roomCode,
                                    'stay_type' => $roomStay->stayType,
                                    'description' => $roomStay->description ?? null,
                                    'order' => $roomStay->order
                                ];

                                // if (isset($roomStay->roomStayFacilities)) {
                                //     foreach ($roomStay->roomStayFacilities as $roomStayFacility) {
                                //         $roomStayFacilitiesData[] = [
                                //             'hotel_code' => $hotel->code,
                                //             'room_code' => $room->roomCode,
                                //             'room_stay_type' => $roomStay->stayType,
                                //             'facility_code' => $roomStayFacility->facilityCode,
                                //             'facility_group_code' => $roomStayFacility->facilityGroupCode,
                                //             'number' => $roomStayFacility->number,
                                //         ];
                                //     }
                                // }
                            }
                        }
                    }
                }

                foreach ($hotel->facilities as $facility) {
                    $facilitiesData[] = [
                        'hotel_code' => $hotel->code,
                        'facility_code' => $facility->facilityCode,
                        'facility_group_code' => $facility->facilityGroupCode,
                        'order' => $facility->order ?? null,
                        'number' => $facility->number ?? null,
                        'voucher' => $facility->voucher ?? null,
                        'ind_yes_no' => $facility->indYesOrNo ?? null,
                        'ind_logic' => $facility->indLogic ?? null,
                        'ind_fee' => $facility->indFee ?? null,
                        'distance' => $facility->distance ?? null,
                        'time_from' => $facility->timeFrom ?? null,
                        'time_to' => $facility->timeTo ?? null,
                        'date_from' => $facility->dateFrom ?? null,
                        'date_to' => $facility->dateTo ?? null,
                        'age_from' => $facility->ageFrom ?? null,
                        'age_to' => $facility->ageTo ?? null,
                        'currency' => $facility->currency ?? null,
                        'amount' => $facility->amount ?? null,
                        'application_type' => $facility->applicationType ?? null,
                    ];
                }

                foreach (array_chunk($facilitiesData, 1000) as $value) {
                    $db->table('hotels_facilities')->insertBatch($value);
                }
                $facilitiesData = null;

                if (isset($hotel->terminals)) {
                    foreach ($hotel->terminals as $terminal) {
                        $terminalsData[] = [
                            'hotel_code' => $hotel->code,
                            'terminal_code' => $terminal->terminalCode,
                            'distance' => $terminal->distance
                        ];
                    }
                }

                if (isset($hotel->issues)) {
                    foreach ($hotel->issues as $issue) {
                        $issuesData[] = [
                            'hotel_code' => $hotel->code,
                            'issue_code' => $issue->issueCode,
                            'issue_type' => $issue->issueType,
                            'date_from' => $issue->dateFrom,
                            'date_to' => $issue->dateTo,
                            'order' => $issue->order,
                            'alternative' => $issue->alternative,
                        ];
                    }
                }

                if (isset($hotel->images)) {
                    foreach ($hotel->images as $image) {
                        $imagesData[] = [
                            'hotel_code' => $hotel->code,
                            'image_type_code' => $image->imageTypeCode,
                            'path' => $image->path,
                            'order' => $image->order,
                            'visual_order' => $image->visualOrder,
                            'room_code' => $image->roomCode ?? '',
                            'room_type' => $image->roomType ?? '',
                            'characteristic_code' => $image->characteristicCode ?? null,
                        ];
                    }
                    if (count($imagesData) >= 1000) {
                        $db->transStart();
                        foreach (array_chunk($imagesData, 1000) as $value) {
                            $db->table('hotels_images')->insertBatch($value);
                        }
                        $imagesData = null;
                        $db->transComplete();
                    }
                }

                if (isset($hotel->wildcards)) {
                    foreach ($hotel->wildcards as $wildcard) {
                        $wildcardsData[] = [
                            'hotel_code' => $hotel->code,
                            'room_code' => $wildcard->roomType,
                            'room_type' => $wildcard->roomCode,
                            'characteristic_code' => $wildcard->characteristicCode,
                            'hotel_room_description' => $wildcard->hotelRoomDescription->content,
                        ];
                    }
                }

                $hotel = null;
            }

            $hotels = null;

            echo 'after second foreach';
            echo (memory_get_usage(true) / 1024 / 1024) . 'MB';
            echo "<br>";

            $db->transStart();
            foreach (array_chunk($hotelBoardsData, 1000) as $value) {
                $db->table('hotels_boards')->insertBatch($value);
                $value = null;
            }
            $hotelBoardsData = null;

            foreach (array_chunk($hotelSegmentsData, 1000) as $value) {
                $db->table('hotels_segments')->insertBatch($value);
                $value = null;
            }
            $hotelSegmentsData = null;

            foreach (array_chunk($phonesData, 1000) as $value) {
                $db->table('phones')->insertBatch($value);
                $value = null;
            }
            $phonesData = null;

            foreach (array_chunk($roomStaysData, 1000) as $value) {
                $db->table('room_stays')->insertBatch($value);
                $value = null;
            }
            $roomStaysData = null;

            foreach (array_chunk($terminalsData, 300) as $value) {
                $db->table('hotels_terminals')->insertBatch($value);
                $value = null;
            }
            $terminalsData = null;

            foreach (array_chunk($issuesData, 300) as $value) {
                $db->table('hotels_issues')->insertBatch($value);
                $value = null;
            }
            $issuesData = null;

            foreach (array_chunk($wildcardsData, 300) as $value) {
                $db->table('hotels_wildcards')->insertBatch($value);
                $value = null;
            }
            $wildcardsData = null;
            $db->transComplete();

            echo 'end of foreach';
            echo "<br>";
            echo (memory_get_usage(true) / 1024 / 1024) . 'MB';
            echo "<br>";
            gc_collect_cycles();
            echo "<br>";
            echo "<br>";
            echo 'Success';
            // die('Success!');
        }
    }

    // public function saveHotels()
    // {
    //     $db = \Config\Database::connect();
    //     // echo 'before first foreach';
    //     // echo memory_get_usage();
    //     // echo "<br>";
    //     foreach ($this->fetchHotels() as $hotels) {
    //         echo 'inside first foreach';
    //         echo "<br>";
    //         echo (memory_get_usage(true) / 1024 / 1024) . 'MB';
    //         echo "<br>";
    //         // die(json_encode($hotel));
    //         $latestHotel = (new HotelModel())->orderBy('code', 'desc')->first();
    //         // die(json_encode(end($hotels)->code));
    //         // die(json_encode($hotels));
    //         // die(json_encode(end($hotels)->code));
    //         if ($latestHotel && end($hotels)->code <= $latestHotel->code) continue;
    //         $latestHotel = null;
    //         $data = [];
    //         foreach ($hotels as $hotel) {
    //             $data[] = [
    //                 'code' => $hotel->code,
    //                 'name' => $hotel->name->content,
    //                 'description' => $hotel->description->content ?? null,
    //                 'country_code' => $hotel->countryCode,
    //                 'state_code' => $hotel->stateCode,
    //                 'destination_code' => $hotel->destinationCode,
    //                 'zone_code' => $hotel->zoneCode ?? null,
    //                 'longitude' => $hotel->coordinates->longitude ?? null,
    //                 'latitude' => $hotel->coordinates->latitude ?? null,
    //                 'category_code' => $hotel->categoryCode ?? null,
    //                 'category_group_code' => $hotel->categoryGroupCode ?? null,
    //                 'chain_code' => $hotel->chainCode ?? null,
    //                 'accommodation_type_code' => $hotel->accommodationTypeCode ?? null,
    //                 'address' => $hotel->address->content,
    //                 'postal_code' => $hotel->postalCode ?? null,
    //                 'city' => $hotel->city->content,
    //                 'email' => $hotel->email ?? null,
    //                 'license' => $hotel->license ?? null,
    //                 'web' => $hotel->web ?? null,
    //                 'last_update' => $hotel->lastUpdate,
    //                 'S2C' => $hotel->S2C ?? null,
    //                 'ranking' => $hotel->ranking ?? null,
    //             ];
    //         }
    //         $hotel = null;
    //         if (count($data)) {
    //             foreach (array_chunk($data, 1000) as $value) {
    //                 (new HotelModel())->insertBatch($value);
    //             }
    //             $data = null;
    //         }

    //         foreach ($hotels as $hotel) {
    //             echo 'inside second foreach';
    //             echo "<br>";
    //             echo 'hotel code is: ' . $hotel->code;
    //             echo "<br>";
    //             echo memory_get_usage();
    //             echo "<br>";
    //             //     // $data = [
    //             //     //     'code' => $hotel->code,
    //             //     //     'name' => $hotel->name->content,
    //             //     //     'description' => $hotel->description->content,
    //             //     //     'country_code' => $hotel->countryCode,
    //             //     //     'state_code' => $hotel->stateCode,
    //             //     //     'destination_code' => $hotel->destinationCode,
    //             //     //     'zone_code' => $hotel->zoneCode,
    //             //     //     'longitude' => $hotel->coordinates->longitude,
    //             //     //     'latitude' => $hotel->coordinates->latitude,
    //             //     //     'category_code' => $hotel->categoryCode,
    //             //     //     'category_group_code' => $hotel->categoryGroupCode,
    //             //     //     'chain_code' => $hotel->chainCode ?? null,
    //             //     //     'accommodation_type_code' => $hotel->accommodationTypeCode,
    //             //     //     'address' => $hotel->address->content,
    //             //     //     'postal_code' => $hotel->postalCode ?? null,
    //             //     //     'city' => $hotel->city->content,
    //             //     //     'email' => $hotel->email ?? null,
    //             //     //     'license' => $hotel->license ?? null,
    //             //     //     'web' => $hotel->web ?? null,
    //             //     //     'last_update' => $hotel->lastUpdate,
    //             //     //     'S2C' => $hotel->S2C ?? null,
    //             //     //     'ranking' => $hotel->ranking,
    //             //     // ];

    //             //     // (new HotelModel())->insert($data);
    //             //     // unset($data);

    //             if (isset($hotel->boardCodes)) {
    //                 foreach ($hotel->boardCodes as $board) {
    //                     if ($board == null) {
    //                         continue;
    //                     }
    //                     $hotelBoardsData[] = [
    //                         'hotel_code' => $hotel->code,
    //                         'board_code' => $board
    //                     ];
    //                 }
    //             }

    //             foreach ($hotel->segmentCodes as $segment) {
    //                 $hotelSegmentsData[] = [
    //                     'hotel_code' => $hotel->code,
    //                     'segment_code' => $segment
    //                 ];
    //             }

    //             foreach ($hotel->phones as $phone) {
    //                 $phonesData[] = [
    //                     'hotel_code' => $hotel->code,
    //                     'phone_number' => $phone->phoneNumber,
    //                     'phone_type' => $phone->phoneType
    //                 ];
    //             }

    //             if (isset($hotel->rooms)) {
    //                 foreach ($hotel->rooms as $room) {
    //                     $roomsData[] = [
    //                         'hotel_code' => $hotel->code,
    //                         'room_code' => $room->roomCode
    //                     ];

    //                     if (count($roomsData) >= 1000) {
    //                         $db->transStart();
    //                         foreach (array_chunk($roomsData, 1000) as $value) {
    //                             $db->table('hotels_rooms')->insertBatch($value);
    //                         }
    //                         unset($roomsData);
    //                         $db->transComplete();
    //                     }

    //                     if (isset($room->roomFacilities)) {
    //                         foreach ($room->roomFacilities as $roomFacility) {
    //                             $roomFacilitiesData[] = [
    //                                 'hotel_code' => $hotel->code,
    //                                 'room_code' => $room->roomCode,
    //                                 'facility_code' => $roomFacility->facilityCode,
    //                                 'facility_group_code' => $roomFacility->facilityGroupCode,
    //                                 'ind_fee' => $roomFacility->indFee ?? null,
    //                                 'ind_logic' => $roomFacility->indLogic ?? null,
    //                                 'ind_yes_no' => $roomFacility->indYesOrNo ?? null,
    //                                 'number' => $roomFacility->number ?? null,
    //                                 'order' => $roomFacility->order ?? null,
    //                                 'voucher' => $roomFacility->voucher ?? null,
    //                             ];
    //                         }

    //                         if (count($roomFacilitiesData) >= 1000) {
    //                             $db->transStart();
    //                             foreach (array_chunk($roomFacilitiesData, 1000) as $value) {
    //                                 $db->table('rooms_facilities')->insertBatch($value);
    //                             }
    //                             unset($roomFacilitiesData);
    //                             $db->transComplete();
    //                         }
    //                     }

    //                     if (isset($room->roomStays)) {
    //                         foreach ($room->roomStays as $roomStay) {
    //                             $roomStaysData[] = [
    //                                 'hotel_code' => $hotel->code,
    //                                 'room_code' => $room->roomCode,
    //                                 'stay_type' => $roomStay->stayType,
    //                                 'description' => $roomStay->description ?? null,
    //                                 'order' => $roomStay->order
    //                             ];

    //                             // if (isset($roomStay->roomStayFacilities)) {
    //                             //     foreach ($roomStay->roomStayFacilities as $roomStayFacility) {
    //                             //         $roomStayFacilitiesData[] = [
    //                             //             'hotel_code' => $hotel->code,
    //                             //             'room_code' => $room->roomCode,
    //                             //             'room_stay_type' => $roomStay->stayType,
    //                             //             'facility_code' => $roomStayFacility->facilityCode,
    //                             //             'facility_group_code' => $roomStayFacility->facilityGroupCode,
    //                             //             'number' => $roomStayFacility->number,
    //                             //         ];
    //                             //     }
    //                             // }
    //                         }
    //                     }
    //                 }
    //             }

    //             foreach ($hotel->facilities as $facility) {
    //                 $facilitiesData[] = [
    //                     'hotel_code' => $hotel->code,
    //                     'facility_code' => $facility->facilityCode,
    //                     'facility_group_code' => $facility->facilityGroupCode,
    //                     'order' => $facility->order ?? null,
    //                     'number' => $facility->number ?? null,
    //                     'voucher' => $facility->voucher ?? null,
    //                     'ind_yes_no' => $facility->indYesOrNo ?? null,
    //                     'ind_logic' => $facility->indLogic ?? null,
    //                     'ind_fee' => $facility->indFee ?? null,
    //                     'distance' => $facility->distance ?? null,
    //                     'time_from' => $facility->timeFrom ?? null,
    //                     'time_to' => $facility->timeTo ?? null,
    //                     'date_from' => $facility->dateFrom ?? null,
    //                     'date_to' => $facility->dateTo ?? null,
    //                     'age_from' => $facility->ageFrom ?? null,
    //                     'age_to' => $facility->ageTo ?? null,
    //                     'currency' => $facility->currency ?? null,
    //                     'amount' => $facility->amount ?? null,
    //                     'application_type' => $facility->applicationType ?? null,
    //                 ];
    //             }

    //             // $db->transStart();
    //             foreach (array_chunk($facilitiesData, 1000) as $value) {
    //                 $db->table('hotels_facilities')->insertBatch($value);
    //             }
    //             unset($facilitiesData);
    //             // $db->transComplete();

    //             if (isset($hotel->terminals)) {
    //                 foreach ($hotel->terminals as $terminal) {
    //                     $terminalsData[] = [
    //                         'hotel_code' => $hotel->code,
    //                         'terminal_code' => $terminal->terminalCode,
    //                         'distance' => $terminal->distance
    //                     ];
    //                 }
    //             }

    //             if (isset($hotel->issues)) {
    //                 foreach ($hotel->issues as $issue) {
    //                     $issuesData[] = [
    //                         'hotel_code' => $hotel->code,
    //                         'issue_code' => $issue->issueCode,
    //                         'issue_type' => $issue->issueType,
    //                         'date_from' => $issue->dateFrom,
    //                         'date_to' => $issue->dateTo,
    //                         'order' => $issue->order,
    //                         'alternative' => $issue->alternative,
    //                     ];
    //                 }
    //             }

    //             if (isset($hotel->images)) {
    //                 foreach ($hotel->images as $image) {
    //                     $imagesData[] = [
    //                         'hotel_code' => $hotel->code,
    //                         'image_type_code' => $image->imageTypeCode,
    //                         'path' => $image->path,
    //                         'order' => $image->order,
    //                         'visual_order' => $image->visualOrder,
    //                         'room_code' => $image->roomCode ?? '',
    //                         'room_type' => $image->roomType ?? '',
    //                         'characteristic_code' => $image->characteristicCode ?? null,
    //                     ];
    //                 }
    //                 if (count($imagesData) >= 1000) {
    //                     $db->transStart();
    //                     foreach (array_chunk($imagesData, 1000) as $value) {
    //                         $db->table('hotels_images')->insertBatch($value);
    //                     }
    //                     unset($imagesData);
    //                     $db->transComplete();
    //                 }
    //             }

    //             if (isset($hotel->wildcards)) {
    //                 foreach ($hotel->wildcards as $wildcard) {
    //                     $wildcardsData[] = [
    //                         'hotel_code' => $hotel->code,
    //                         'room_code' => $wildcard->roomType,
    //                         'room_type' => $wildcard->roomCode,
    //                         'characteristic_code' => $wildcard->characteristicCode,
    //                         'hotel_room_description' => $wildcard->hotelRoomDescription->content,
    //                     ];
    //                 }
    //             }

    //             unset($hotel);
    //         }

    //         $hotels = null;

    //         echo 'after second foreach';
    //         echo memory_get_usage();
    //         echo "<br>";
    //         $db      = \Config\Database::connect();


    //         // $db->transStart();
    //         // foreach (array_chunk($data, 300) as $value) {
    //         //     (new HotelModel())->insertBatch($value);
    //         // }
    //         // unset($data);
    //         // $db->transComplete();

    //         $db->transStart();
    //         foreach (array_chunk($hotelBoardsData, 1000) as $value) {
    //             $db->table('hotels_boards')->insertBatch($value);
    //             unset($value);
    //         }
    //         $hotelBoardsData = null;
    //         // $db->transComplete();


    //         // $db->transStart();
    //         foreach (array_chunk($hotelSegmentsData, 1000) as $value) {
    //             $db->table('hotels_segments')->insertBatch($value);
    //             $value = null;
    //         }
    //         $hotelSegmentsData = null;
    //         // $db->transComplete();

    //         // $db->transStart();
    //         foreach (array_chunk($phonesData, 1000) as $value) {
    //             $db->table('phones')->insertBatch($value);
    //             $value = null;
    //         }
    //         $phonesData = null;
    //         // $db->transComplete();

    //         // $db->transStart();
    //         // foreach (array_chunk($roomsData, 300) as $value) {
    //         //     $db->table('hotels_rooms')->insertBatch($value);
    //         // }
    //         // unset($roomsData);
    //         // $db->transComplete();

    //         // $db->transStart();
    //         // foreach (array_chunk($roomFacilitiesData, 300) as $value) {
    //         //     $db->table('rooms_facilities')->insertBatch($value);
    //         // }
    //         // unset($roomFacilitiesData);
    //         // $db->transComplete();

    //         // $db->transStart();
    //         foreach (array_chunk($roomStaysData, 1000) as $value) {
    //             $db->table('room_stays')->insertBatch($value);
    //             $value = null;
    //         }
    //         $roomStaysData = null;
    //         // $db->transComplete();

    //         // $roomStayFacilities = $db->table('room_stay_facilities');
    //         // $roomStayFacilities->insertBatch($roomStayFacilitiesData);

    //         // $db->transStart();
    //         // foreach (array_chunk($facilitiesData, 1000) as $value) {
    //         //     $db->table('hotels_facilities')->insertBatch($value);
    //         // }
    //         // unset($facilitiesData);
    //         // $db->transComplete();

    //         // $db->transStart();
    //         foreach (array_chunk($terminalsData, 300) as $value) {
    //             $db->table('hotels_terminals')->insertBatch($value);
    //             $value = null;
    //         }
    //         $terminalsData = null;

    //         foreach (array_chunk($issuesData, 300) as $value) {
    //             $db->table('hotels_issues')->insertBatch($value);
    //             $value = null;
    //         }
    //         $issuesData = null;
    //         // $db->transComplete();

    //         // $db->transStart();
    //         // foreach (array_chunk($imagesData, 300) as $value) {
    //         //     $db->table('hotels_images')->insertBatch($value);
    //         // }
    //         // unset($imagesData);
    //         // $db->transComplete();

    //         // $db->transStart();
    //         foreach (array_chunk($wildcardsData, 300) as $value) {
    //             $db->table('hotels_wildcards')->insertBatch($value);
    //             $value = null;
    //         }
    //         $wildcardsData = null;
    //         $db->transComplete();

    //         echo 'end of foreach';
    //         echo "<br>";
    //         echo (memory_get_usage(true) / 1024 / 1024) . 'MB';
    //         echo "<br>";
    //         // die('done!');
    //         gc_collect_cycles();
    //     }
    //     echo "<br>";
    //     echo "<br>";
    //     echo 'Success';
    //     // die('Success!');
    // }
}
