<?php

namespace App\Controller;

use Exception;
use App\Repository\ActivitesRepository;
use App\Repository\ExcursionsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CatalogueController extends AbstractController
{
    #[Route('/catalogue/{type}', name: 'app_catalogue')]
    public function index(string $type, ActivitesRepository $ar,ExcursionsRepository $er): Response
    {
        $carteCollection = match ($type) {
            'activites' => $ar->findAll(),
            'excursions' => $er->findAll(),
            default => throw new NotFoundHttpException("Resource not found for type: $type"),
             
        };
        // dd($carteCollection);

        return $this->render('catalogue/index.html.twig', [
            'collection' => $carteCollection,
            'type' => $type,
        ]);
    }
}
