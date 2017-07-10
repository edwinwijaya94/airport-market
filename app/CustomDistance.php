<?php

namespace App;

use Phpml\Math\Distance;

class CustomDistance implements Distance
{
    private $distanceMetric;

    public function __construct(Distance $distanceMatrix){
        $this->distanceMetric = $distanceMatrix;
    }

    /**
     * @param array $orderA
     * @param array $orderB
     *
     * @return float
     */
    public function distance(array $orderA, array $orderB): float
    {
        return $this->distanceMetric[$orderA][$orderB];
    }
}