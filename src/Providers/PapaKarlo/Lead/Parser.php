<?php

namespace A1ex7\Cpa\Providers\PapaKarlo\Lead;


use A1ex7\Cpa\Lead\LeadInfo;
use A1ex7\Cpa\Lead\LeadParser;
use A1ex7\Cpa\Lead\LeadSource;
use A1ex7\Cpa\Lead\Parser\QueryParams;

class Parser implements LeadParser
{
    use QueryParams;

    protected const UTM_SOURCE = 'papakarlo';
    protected const CLICK_ID   = 'clickid';

    public function parse(string $url): ?LeadInfo
    {
        $query = $this->getQueryParams($url);
        $isQueryValid = ($query['utm_source'] ?? null) === static::UTM_SOURCE
            && array_key_exists(static::CLICK_ID, $query);

        if (!$isQueryValid) {
            return null;
        }

        return new LeadInfo(
            LeadSource::PAPA_KARLO,
            [
                'clickId'  => $query[static::CLICK_ID],
                'utm_term' => $query['utm_term'] ?? null,
            ]
        );
    }
}