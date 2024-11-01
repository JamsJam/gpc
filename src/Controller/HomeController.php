<?php

namespace App\Controller;

use Symfony\UX\Map\Map;
use Symfony\UX\Map\Point;
use Symfony\UX\Map\Marker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\Reservation\ContactType as ReservationType1;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $gp_map = (new Map())
            ->center(new Point(16.255207,-61.571382))
            ->zoom(10.6)
            //todo Add Marker form a coordTable
            ->addMarker(new Marker(
                position: new Point(16.255207,-61.571382), 
                title: 'Guadeloupe'
            ))
        ;


        
        return $this->render('home/index.html.twig', [
            'map' => $gp_map,
        ]);
    }
}
