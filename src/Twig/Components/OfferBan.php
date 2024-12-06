<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class OfferBan
{
    public string $titre;
    public string $text;
    public string $ctatitre;
}
