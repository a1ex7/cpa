<?php

namespace A1ex7\Cpa\Providers\LeadGid;

use A1ex7\Cpa\Traits\EnvironmentConfigTrait;

class EnvironmentConfig
{
    use EnvironmentConfigTrait;

    public $keyPrefix = 'LEAD_GID_';

    public function getOfferId(?string $product = null): int
    {
        return env($this->getProductPrefix($product) . 'OFFER_ID', 0);
    }
}