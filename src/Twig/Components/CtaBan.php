<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
final class CtaBan
{
    public string $titre;
    public string $text;
    public string $ctatitre;
}
