<?php

namespace A1ex7\Cpa\LeadGid;

use A1ex7\Cpa\EnvironmentConfigTrait;

class EnvironmentConfig
{
    use EnvironmentConfigTrait;

    public $keyPrefix = 'LEAD_GID_';

    public function getOfferId(?string $product = null): int
    {
        return env($this->getProductPrefix($product) . 'OFFER_ID', 0);
    }
}