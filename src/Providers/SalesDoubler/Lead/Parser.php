<?php

namespace A1ex7\Cpa\Providers\SalesDoubler\Lead;


use A1ex7\Cpa\Lead\LeadInfo;
use A1ex7\Cpa\Lead\Parser\QueryParams;

class Parser implements \A1ex7\Cpa\Interfaces\Lead\LeadParser
{
    use QueryParams;

    protected const AFF_SUB = 'aff_sub';
    protected const AFF_ID  = 'aff_id';
    protected const UTM_SOURCES = [
        'cpanet_salesdoubler',
        'cpanet_salesdubler',
        'salesdoubler'
    ];

    public function parse(string $url): ?LeadInfo
    {
        $query = $this->getQueryParams($url);
        $isQueryValid = in_array($query['utm_source'] ?? null, static::UTM_SOURCES, true)
            && array_key_exists(static::AFF_SUB, $query);
        if (!$isQueryValid) {
            return null;
        }

        return new LeadInfo(
            \A1ex7\Cpa\Interfaces\Lead\LeadSource::SALES_DOUBLER,
            [
                'clickId' => $query[static::AFF_SUB],
                'aid'     => $query[static::AFF_ID] ?? $query['utm_campaign'] ?? null,
            ]
        );
    }
}