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
            "titre" => "Rencontre avec les cétacé",
            "lat" => 16.1723981,
            "long" => -61.7871479, //16.1723981,-61.7871479
            "description" => "lorem ipsum"
        ],
        [
            "titre" => "Escape game en plaine air",
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
            "titre" => "Randonnée massif de la Soufrière",
            "lat" => 16.0499995,
            "long" => -61.6769667,
            "description" => "lorem ipsum"
        ],

    ];

    public array $excursionMarkers = [
        [
            "titre" => "Parc national de Guadeloupe",
            "lat" => 16.1309319,
            "long" =>-61.6840267,
            "description" => "lorem ipsum"
        ],
        [
            "titre" => "La Désirade",
            "lat" => 16.3199244,
            "long" => -61.0708992, 
            "description" => "lorem ipsum"
        ],
        [
            "titre" => "Marie-galante",
            "lat" => 15.9368828,
            "long" =>-61.3072499, 
            "description" => "lorem ipsum"
        ],
        [
            "titre" => "Terre-de-bas",
            "lat" => 15.8554203,
            "long" => -61.6429921, 
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
