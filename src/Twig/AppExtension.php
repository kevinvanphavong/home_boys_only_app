<?php

namespace App\Twig;

use DateTime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('age', [$this, 'getAgeWithBirdate']),
        ];
    }

    public function getAgeWithBirdate(DateTime $partygoerBirthdate): string
    {
        return $partygoerBirthdate->diff(new DateTime())->format('%y');
    }
}