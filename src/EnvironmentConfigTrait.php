<?php

namespace A1ex7\Cpa;

trait EnvironmentConfigTrait
{
    protected function appendProductPrefix(string $envKey, ?string $product = null): string
    {
        return $this->getProductPrefix($product) . $envKey;
    }

    protected function getProductPrefix(?string $product = null): string
    {
        if (!$product) {
            return $this->keyPrefix;
        }

        return mb_strtoupper($product) . '_';
    }
}