<?php

namespace A1ex7\Cpa\DoAffiliate\Lead;


use A1ex7\Cpa\Lead\LeadInfo;
use A1ex7\Cpa\Lead\LeadParser;
use A1ex7\Cpa\Lead\LeadSource;
use A1ex7\Cpa\Lead\Parser\QueryParams;

class Parser implements LeadParser
{
    use QueryParams;

    protected const VISITOR     = 'v';
    protected const UTM_SOURCES = ['doaff', 'doaffiliate'];

    public function parse(string $url): ?LeadInfo
    {
        $query        = $this->getQueryParams($url);
        $isQueryValid = in_array(($query['utm_source'] ?? null), static::UTM_SOURCES, true)
            && array_key_exists(static::VISITOR, $query);

        if (!$isQueryValid) {
            return null;
        }

        return new LeadInfo(
            LeadSource::DO_AFFILIATE,
            [
                'visitor' => $query[static::VISITOR],
            ]
        );
    }
}