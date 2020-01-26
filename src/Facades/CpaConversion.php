<?php

namespace A1ex7\Cpa\Facades;

use A1ex7\Cpa\Models\Conversion;
use Illuminate\Support\Facades\Facade;

/**
 * Class CpaConversion
 * @package A1ex7\Cpa\Facades
 * @method static Conversion register($user, string $conversionId, string $event)
 *
 * @see \A1ex7\Cpa\Conversion\ConversionService
 */
class CpaConversion extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'cpaConversion';
    }
}
