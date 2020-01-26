<?php

namespace A1ex7\Cpa\LeadsSu;

use A1ex7\Cpa\EnvironmentConfigTrait;

class EnvironmentConfig
{
    use EnvironmentConfigTrait;

    public $keyPrefix = 'LEADS_SU_';

    public function getToken(?string $product = null): string
    {
        return env($this->getProductPrefix($product).'TOKEN');
    }

    public function getGoal(?string $product = null): int
    {
        return env($this->getProductPrefix($product).'GOAL');
    }
}