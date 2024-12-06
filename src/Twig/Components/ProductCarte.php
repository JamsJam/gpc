<?php

namespace App\Twig\Components;

use App\Entity\Activites;
use App\Entity\Excursions;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class ProductCarte
{
    public Excursions|Activites $produit;
    public string $type;
}
