<?php

namespace A1ex7\Cpa\StormDigital;

use A1ex7\Cpa\EnvironmentConfigTrait;

class EnvironmentConfig
{
    use EnvironmentConfigTrait;

    public $keyPrefix = 'STORM_DIGITAL_';

    public function getSecure(?string $product = null): string
    {
        return env($this->getProductPrefix($product) . 'SECURE', '');
    }

    public function getGoal(?string $product = null): int
    {
        return env($this->getProductPrefix($product) . 'GOAL', 1);
    }
}