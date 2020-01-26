<?php

namespace A1ex7\Cpa\Providers\StormDigital\Lead;


use A1ex7\Cpa\Lead\LeadInfo;
use A1ex7\Cpa\Lead\LeadParser;
use A1ex7\Cpa\Lead\LeadSource;
use A1ex7\Cpa\Lead\Parser\QueryParams;

class Parser implements LeadParser
{
    use QueryParams;

    protected const UTM_SOURCE = 'stormdigital';
    protected const AFF_SUB    = 'aff_sub';
    protected const AFF_ID     = 'aff_id';

    public function parse(string $url): ?LeadInfo
    {
        $query = $this->getQueryParams($url);
        $isQueryValid = ($query['utm_source'] ?? null) === static::UTM_SOURCE
            && array_key_exists(static::AFF_SUB, $query);

        if (!$isQueryValid) {
            return null;
        }

        return new LeadInfo(
            LeadSource::STORM_DIGITAL,
            [
                'clickId' => $query[static::AFF_SUB],
                'pid'     => $query[static::AFF_ID] ?? null,
            ]
        );
    }
}