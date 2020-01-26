<?php

namespace A1ex7\Cpa\Providers\Credy\Lead;


use A1ex7\Cpa\Interfaces\Lead\LeadSource;
use A1ex7\Cpa\Lead\LeadInfo;
use A1ex7\Cpa\Traits\QueryParams;

class Parser implements \A1ex7\Cpa\Interfaces\Lead\LeadParser
{
    use QueryParams;

    protected const UTM_SOURCE     = 'credy';
    protected const TRANSACTION_ID = 'tid';

    public function parse(string $url): ?LeadInfo
    {
        $query = $this->getQueryParams($url);
        $isQueryValid = ($query['utm_source'] ?? null) === static::UTM_SOURCE
            && array_key_exists(static::TRANSACTION_ID, $query);

        if (!$isQueryValid) {
            return null;
        }

        return new LeadInfo(
            LeadSource::CREDY,
            [
                'tid' => $query[static::TRANSACTION_ID]
            ]
        );
    }
}