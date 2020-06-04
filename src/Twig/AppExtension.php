<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('price', [$this, 'priceFilter'], ['is_safe' => ['html']]),
        ];
    }

    public function getFunctions(): array
    {
        return [];
    }

    public function priceFilter($s, $decimals = 2, $decPoint = ',', $thousandsSep = '.')
    {
        return number_format(($s/1000), $decimals, $decPoint, $thousandsSep);
    }
}
