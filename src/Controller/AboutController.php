<?php

namespace App\Controller;

use App\Trait\LocaleTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AboutController extends AbstractController
{
    use LocaleTrait;
    
    #[Route('/apropos', name: 'app_about')]
    public function index(Request $request): Response
    {
        $locale = $request->getLocale();
        $redirect = $this->handleLocale($request);
        if($redirect){
            return $redirect;
        }

        return $this->render('about/index.html.twig', [
            'locale' => $locale,
        ]);
    }
}
