<?php

namespace A1ex7\Cpa\Facades;

use A1ex7\Cpa\Models\CpaCookie;
use A1ex7\Cpa\Models\Lead;
use Illuminate\Support\Facades\Facade;

/**
 * Class CpaLead
 * @package A1ex7\Cpa\Facades
 *
 * @method static Lead|null getLastLeadByUser($user): ?Lead
 * @method static Lead|null create($user, $urls): ?Lead
 * @method static Lead|null createFromCookie($user): ?Lead
 * @method static CpaCookie storeToCookie($url)
 *
 * @see \A1ex7\Cpa\Lead\LeadService
 */
class CpaLead extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'cpaLead';
    }
}
