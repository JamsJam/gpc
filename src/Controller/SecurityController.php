<?php

namespace App\Controller;

use App\Trait\LocaleTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    use LocaleTrait;

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils,Request $request): Response
    {
        $locale = $request->getLocale();
        $redirect = $this->handleLocale($request);
        if($redirect){
            return $redirect;
        }

        if($this->getUser()){
            $this->addFlash(
                'warning',
                'Vous etes deja connecté en tant que '. $this->getUser()->getPrenom() . '' . $this->getUser()->getNom() 
            );
            return $this->redirectToRoute('admin');
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'locale'=> $locale
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
