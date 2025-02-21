<?php

namespace App\Twig\Components;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class Weather
{
    use DefaultActionTrait;

    //! call api --> return json data and process with stimulus
    // public function __construct(
    //     private HttpClientInterface $httpClient,
    //     private string $apiOWMKey

    // ){}

    // public function getWeatherData(
    //     $lat, $long, $time
    // ):array
    // {
    //     try {
            
    //         $response = $this->httpClient->request(
    //             'GET', 
    //             `https://api.openweathermap.org/data/3.0/onecall/timemachine?lat={$lat}&lon={$long}&dt={$time}&appid={$this->apiOWMKey}`
    //         );
    //         $content = $response->getContent();
    //         $statusCode = $response->getStatusCode();

    //         return $content;
    //     } catch (\Throwable $e) {
    //         return ['error' => 'Erreur lors de la récupération des données : ' . $e];
    //     }
    // }


}
