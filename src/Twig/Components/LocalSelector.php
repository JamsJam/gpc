<?php

namespace App\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent]
final class LocalSelector extends AbstractController
{
    use DefaultActionTrait;


    #[LiveProp(writable:true)]
    public string $currentLocale;
    // public string $currentRoute;

    
    
    // private SessionInterface $session;
    private RequestStack $requestStack;
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(
        // SessionInterface $session,
        RequestStack $requestStack,
        UrlGeneratorInterface $urlGenerator,
    )
    {
        // $this->session = $session;
        $this->requestStack = $requestStack;
        $this->urlGenerator = $urlGenerator;
        // $this->currentLocale = $this->session->get('_locale', 'en');
    }

    #[LiveAction]
    public function switchLocale(#[LiveArg] string $locale): RedirectResponse
    {
        // $this->session->set('_locale', $locale);
        $this->currentLocale = $locale;


        // Get the current request
        $request = $this->requestStack->getCurrentRequest();

        // Retrieve the current route name and parameters
        $routeName = $request->attributes->get('_route');
        // dd($request);
        $routeParams = $request->attributes->get('_route_params', ['_locale' => $locale]);

        // Regenerate the URL for the current route with the new locale
        $redirectUrl = $this->urlGenerator->generate($routeName, $routeParams);
        return new RedirectResponse($redirectUrl);
    }
}

