<?php

namespace A1ex7\Cpa\Providers\DoAffiliate;

use A1ex7\Cpa\EnvironmentConfigTrait;

class EnvironmentConfig
{
    use EnvironmentConfigTrait;

    public $keyPrefix = 'DO_AFFILIATE_';

    public function getPath(?string $product = null): string
    {
        return env($this->appendProductPrefix('PATH', $product));
    }
}