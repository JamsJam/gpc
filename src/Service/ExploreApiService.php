<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExploreApiService{


    function __construct(
        private HttpClientInterface $client,
        private string $exploreLink,
        private string $exploreTkn,
        private string $testApiLink
    )
    {}


    public function sendLeadsToExplore(
        array $leads = [
            "name" => null,
            "phoneNumber" => null,
            "email" => null,
            "nationnality" => null,
            "startDate" => null,
            "endDate" => null,
            "portArrival" => 'guadeloupe',
            "modeOfArrival" => "plane",
            "comment" => null
        ]
    )
    {



        $payload = [
            "name" => $leads["name"] ?? null,
            "phoneNumber" => $leads["phoneNumber"] ?? null,
            "email" => $leads["email"] ?? null,
            "nationality" => $leads["nationality"] ?? null,
            "startDate" => $leads["startDate"]  ?? null,
            "endDate" => $leads["endDate"] ?? null,
            "portArrival" => $leads["portArrival"] ?? null ,
            "modeOfArrival" => $leads["modeOfArrival"] ?? null ,
            "comment" => $leads["comment"] ?? null
        ];

        //header
        //x-tenant-token:
        // $this->client = $client->withoptions([]);
        // dd($leads);
        $response = $this->client->request(
            'POST',
            // 'https://httpbin.org/post'
            $this->testApiLink,
            [
                'headers' =>[
                    "x-tenant-token" => $this->exploreTkn,
                    "content-type" => "application/json"
                ],
                'body' => json_encode($payload),
                
            ]
        );
        dd($response->toArray());
    }
}