<?php

namespace App\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsLiveComponent()]
class Navbar
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public ?bool $isMobile = true ;

    #[LiveProp(writable: true)]
    public bool $loading = false ;
    
    #[LiveProp(writable: true)]
    public ?string $route = "";



    #[LiveAction]
    public function setMobile(#[LiveArg]bool $a)
    {
        $this->isMobile = $a;
    }
}
