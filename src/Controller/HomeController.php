<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\PromosRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home' )]
    public function index(PromosRepository $pr, Request $request): Response
    {

        $locale = $request->getLocale();
        $request->getSession()->set('_locale', $locale);
        if($request->query->get('_locale')){
            $request->getSession()->set('_locale',$request->query->get('_locale'));
            // $request->setLocale($request->getSession()->get('_locale'));
            // $locale = $request->getLocale();

            return $this->redirectToRoute('app_home');
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
