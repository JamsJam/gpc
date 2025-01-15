<?php

namespace App\Controller;


use DateTime;
use App\Trait\LocaleTrait;

use App\Repository\PromosRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    use LocaleTrait ;
    
    #[Route('/', name: 'app_home' )]
    public function index(PromosRepository $pr, Request $request): Response
    {

        $locale = $request->getLocale();
        $redirect = $this->handleLocale($request);
        if($redirect){
            return $redirect;
        }
        

        $offerResult = $pr->findTodayOffer(new DateTime());
        // $request->getSession()->set('_locale', 'en');
        $offer =  isset($offerResult) ? [
            "start" => $offerResult->getBeginAt(),
            "end"   => $offerResult->getEndAt(),
            'titre' => $offerResult->getTitre(),
            'image' => $offerResult->getImage(),
            'pack1' => [
                "contenu" => $offerResult->getPack1(),
                "prix" => $offerResult->getPrix1()/100,
                "lien" => $offerResult->getStripeLink1(),
            ],
            'pack2' => [
                "contenu" => $offerResult->getPack2(),
                "prix" => $offerResult->getPrix2()/100,
                "lien" => $offerResult->getStripeLink2(),
            ],

        ] : null;

        
        return $this->render('home/index.html.twig', [
            'offer' => $offer,
            'locale' => $locale
        ]);
    }
}
