<?php

namespace App\Twig\Components;

use Symfony\UX\Map\Map;
use Symfony\UX\Map\Point;
use Symfony\UX\Map\Marker;
use Symfony\UX\Map\InfoWindow;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;

#[AsLiveComponent]
final class ActivitieSwitch
{
    use DefaultActionTrait;


    #[LiveProp(writable:true)]
    public string $mode = "activities";

    public array $activiteMarkers = [
        [
            "titre" => "Art road tour",
            "lat" => 16.2331311,
            "long" => -61.5520486,
            "description" => "lorem ipsum"
        ],
        [
            "titre" => "Art et design fleural",
            "lat" => 15.9931362,
            "long" => -61.6905296,
            "description" => "lorem ipsum"
        ],
        [
            "titre" => "Randonnées nature",
            "lat" => 16.0499995,
            "long" => -61.6769667,
            "description" => "lorem ipsum"
        ],
        [
            "titre" => "Masterclass gastronomique",
            "lat" => 16.1767479,
            "long" => -61.6092936, 
            "description" => "lorem ipsum"
        ],

    ];

    public array $excursionMarkers = [

        [
            "titre" => "Patrimoine des saveurs",
            "lat" => 16.0391367,
            "long" => -61.6547454, //capesterre
            "description" => "lorem ipsum"
        ],
        [
            "titre" => "Un rhum de legende sur une terre de legende",
            "lat" => 15.9368828,
            "long" =>-61.3072499, //marie-galante
            "description" => "lorem ipsum"
        ],
        [
            "titre" => "Escapade a la desirade",
            "lat" => 16.3199244,
            "long" => -61.0708992,
            "description" => "lorem ipsum"
        ],
        [
            "titre" => "Visite du nord basse-terre",
            "lat" => 16.048552,
            "long" => -61.6609027, //capesterre
            "description" => "lorem ipsum"
        ],


    ];

    public ?object $map = null;

    public function mount(){

        $this->changeMode($this->mode);

    }

    #[LiveAction]
    public function changeMode(#[LiveArg]string $mode){
        $this->mode = $mode;
        $markersArray = match ($this->mode) {
            'activities'    =>  $this->activiteMarkers,
            'excursions'     => $this->excursionMarkers,
            default => [],
        };
        // dd($this->mode,$mode, $markersArray);
        $this->mapInitialise($markersArray);
        
    }


    public function mapInitialise(array $arrayPoint){
        
        $map = new Map();

            foreach ($arrayPoint as  $item) {
                
                //todo Add Marker form a coordTable
                $map->addMarker(new Marker(
                    position: new Point($item["lat"],$item["long"]), 
                    title: $item["titre"],
                    infoWindow: new InfoWindow(
                        headerContent: '<b>'.$item["titre"].'</b>',
                        content: $item["description"]
                    )
                ));
            };
            if (count($arrayPoint) > 0) {
                $map
                    ->fitBoundsToMarkers();
            } else {
                $map
                    ->center(new Point(16.255207, -61.571382))
                    ->zoom(10.6);
            }
        ;

        $this->map = $map;
        
    }






}
