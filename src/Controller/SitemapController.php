<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SitemapController extends AbstractController
{

    #[Route(path:'/sitemap.xml', name:'app_sitemap' )]
    public function index(Request $request)
    {
        // Nous récupérons le nom d'hôte depuis l'URL
        $hostname = $request->getSchemeAndHttpHost();

        // On initialise un tableau pour lister les URLs
        $urls = [];

        $urls = [
            [
                'loc' => $this->generateUrl('app_home'), // Page d'accueil
                'lastmod' => (new \DateTime())->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ],
            [
                'loc' => $this->generateUrl('app_about'), // Page "À propos"
                'lastmod' => (new \DateTime())->format('Y-m-d'),
                'changefreq' => 'yearly',
                'priority' => '0.5',
            ],
            [
                'loc' => $this->generateUrl('app_contact'), // Page de contact
                'lastmod' => (new \DateTime())->format('Y-m-d'),
                'changefreq' => 'yearly',
                'priority' => '0.4',
            ],
            [
                'loc' => $this->generateUrl('app_catalogue',['type' => 'activites']), // Page des services
                'lastmod' => (new \DateTime())->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ],
            [
                'loc' => $this->generateUrl('app_catalogue',['type' => 'excursions']), // Page des services
                'lastmod' => (new \DateTime())->format('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ],
            [
                'loc' => $this->generateUrl('app_reservation'), // Blog principal (statique)
                'lastmod' => (new \DateTime())->format('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.5',
            ],
        ];
        // Fabrication de la réponse XML
        $response = new Response(
            $this->renderView('sitemap/index.html.twig', [
                    'urls' => $urls,
                    'hostname' => $hostname]
            )
        );

        // Ajout des entêtes
        $response->headers->set('Content-Type', 'text/xml');

        // On envoie la réponse
        return $response;
    }
}