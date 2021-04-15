<?php

namespace App\Twig;

use Symfony\Component\Security\Core\Security;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private $security;
    
    public function __construct(Security $security){
        $this->security = $security;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('puraliser', [$this, 'puraliser']),
        ];
    }

    public function puraliser(int $compte, string $singulier, ?string $pluriel = null): string
    {
        $pluriel = $pluriel ?? $singulier . 's';
        $resultat = $compte === 1 ? $singulier : $pluriel;
        return "$compte $resultat" ;
    }
}
