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
            "titre" => "Guadeloupe",
            "lat" => 16.255207,
            "long" => -61.571382,
            "description" => "lorem ipsum"
        ]

    ];

    public array $excursionMarkers = [
        [
            "titre" => "Guadeloupe",
            "lat" => 16.255207,
            "long" => -61.571382,
            "description" => "lorem ipsum"
        ]

    ];

    public ?object $map = null;

    public function mount(){

        $this->mapInitialise($this->activiteMarkers);

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
                        content: 'The French town in the historic Rhône-Alpes region, located at the junction of the Rhône and Saône rivers.'
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
