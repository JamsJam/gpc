<?php

namespace App\Controller;

use Exception;
use App\Trait\LocaleTrait;
use App\Repository\ActivitesRepository;
use App\Repository\ExcursionsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CatalogueController extends AbstractController
{
    use LocaleTrait ;

    #[Route('/catalogue/{type}', name: 'app_catalogue')]
    public function index(Request $request, string $type, ActivitesRepository $ar,ExcursionsRepository $er): Response
    {
        $locale = $request->getLocale();
        $redirect = $this->handleLocale($request);
        if($redirect){
            return $redirect;
        }
        $carteCollection = match ($type) {
            'activites' => $ar->findAll(),
            'excursions' => $er->findAll(),
            default => throw new NotFoundHttpException("Resource not found for type: $type"),
            
        };
        $modalOnPage = true;

        return $this->render('catalogue/index.html.twig', [
            'collection' => $carteCollection,
            'type' => $type,
            'modalOnPage' => $modalOnPage,
            "locale" => $locale
        ]);
    }
}
