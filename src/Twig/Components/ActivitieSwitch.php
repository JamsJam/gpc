<?php

namespace App\Twig\Components;

use Symfony\UX\Map\Map;
use Symfony\UX\Map\Point;
use Symfony\UX\Map\Marker;
use Symfony\UX\Map\InfoWindow;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent]
final class ActivitieSwitch
{
    use DefaultActionTrait;


    public string $mode = "activities";

    public array $activiteMarkers = [
        [
            "titre" => "Guadeloupe",
            "lat" => 16.255207,
            "long" => -61.571382,
            "description" => "lorem ipsum"
        ]

    ];

    public array $excurtionMarkers = [
        [
            "titre" => "",
            "lat" => 0,
            "long" => 0,
        ]

    ];

    public ?object $map = null;

    public function mount(){
        $this->mapInitialise();

    }

    public function mapInitialise(){
        $arrayPoint = $this->mode == "activities" ? $this->activiteMarkers : $this->excurtionMarkers;
        $map = (new Map())
            //  ->center(new Point(16.255207,-61.571382))
            // ->zoom(10.6);
            ->fitBoundsToMarkers();
            foreach ($arrayPoint as  $item) {
                
                //todo Add Marker form a coordTable
                $map->addMarker(new Marker(
                    position: new Point($item["lat"],$item["long"]), 
                    title: $item["titre"],
                    infoWindow: new InfoWindow(
                        headerContent: '<b>'.$item["titre"].'</b>',
                        content: 'The French town in the historic Rhône-Alpes region, located at the junction of the Rhône and Saône rivers.'
                    )
                ));
            };
        ;

        $this->map = $map;
    }






}
