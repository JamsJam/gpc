<?php

namespace App\Controller;

use Symfony\UX\Map\Map;
use Symfony\UX\Map\Point;
use Symfony\UX\Map\Marker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\Reservation\ContactType as ReservationType1;
use App\Repository\PromosRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PromosRepository $pr): Response
    {


        $offer = $pr->findTodayOffer(new DateTime());

        // dd($offer);
        
        return $this->render('home/index.html.twig', [
            'offer' => $offer,
        ]);
    }
}
