<?php

namespace A1ex7\Cpa\Conversion;

use A1ex7\Cpa\Models\Conversion;

interface ServiceInterface
{
    public function register($model, string $conversionId, string $event): ?Conversion;
}