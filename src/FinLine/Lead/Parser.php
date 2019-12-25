<?php

namespace A1ex7\Cpa\FinLine\Lead;


use A1ex7\Cpa\Lead\LeadInfo;
use A1ex7\Cpa\Lead\LeadParser;
use A1ex7\Cpa\Lead\LeadSource;
use A1ex7\Cpa\Lead\Parser\QueryParams;

class Parser implements LeadParser
{
    use QueryParams;

    protected const UTM_SOURCES = ['finline', 'Finline'];
    protected const CLICK_ID   = 'click_id';

    public function parse(string $url): ?LeadInfo
    {
        $query = $this->getQueryParams($url);
        $isQueryValid = in_array(($query['utm_source'] ?? null), static::UTM_SOURCES, true)
            && array_key_exists(static::CLICK_ID, $query);

        if (!$isQueryValid) {
            return null;
        }

        return new LeadInfo(
            LeadSource::FIN_LINE,
            [
                'clickId' => $query[static::CLICK_ID],
            ]
        );
    }
}