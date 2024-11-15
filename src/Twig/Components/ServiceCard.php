<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class ServiceCard
{
    public string $serviceIcon;
    public string $service;
    public string $description;
    public string $target;
    public string $ctaTitle; 
}
