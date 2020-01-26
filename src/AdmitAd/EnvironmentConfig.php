<?php

namespace A1ex7\Cpa\AdmitAd;

use A1ex7\Cpa\EnvironmentConfigTrait;

class EnvironmentConfig
{
    use EnvironmentConfigTrait;

    public $keyPrefix = 'ADMITAD_';

    public function getPostbackKey(?string $product = null): string
    {
        return env($this->getProductPrefix($product).'POSTBACK_KEY');
    }

    public function getCampaignCode(?string $product = null): string
    {
        return env($this->getProductPrefix($product).'CAMPAIGN_CODE');
    }

    public function getActionCode(?string $product = null): int
    {
        return env($this->getProductPrefix($product).'ACTION_CODE');
    }

    public function getTariffCode(?string $product = null): int
    {
        return env($this->getProductPrefix($product).'TARIFF_CODE', 1);
    }
}