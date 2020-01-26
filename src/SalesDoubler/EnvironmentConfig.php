<?php

namespace A1ex7\Cpa\SalesDoubler;

use A1ex7\Cpa\EnvironmentConfigTrait;

class EnvironmentConfig
{
    use EnvironmentConfigTrait;

    public $keyPrefix = 'SALES_DOUBLER_';

    public function getId(?string $product = null): int
    {
        return env($this->getProductPrefix($product) . 'ID', 0);
    }

    public function getToken(?string $product = null): string
    {
        return env($this->getProductPrefix($product) . 'TOKEN', '');
    }
}