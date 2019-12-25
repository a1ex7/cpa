<?php

namespace A1ex7\Cpa\Credy;

use A1ex7\Cpa\EnvironmentConfigTrait;

class EnvironmentConfig
{
    use EnvironmentConfigTrait;

    public $keyPrefix = 'CREDY_';

    public function getOffer(?string $product = null): string
    {
        return env($this->getProductPrefix($product).'OFFER');
    }
}