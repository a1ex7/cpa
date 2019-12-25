<?php

namespace A1ex7\Cpa\LeadsSu\Lead;


use A1ex7\Cpa\Lead\LeadInfo;
use A1ex7\Cpa\Lead\LeadParser;
use A1ex7\Cpa\Lead\LeadSource;
use A1ex7\Cpa\Lead\Parser\QueryParams;

class Parser implements LeadParser
{
    use QueryParams;

    protected const UTM_SOURCE     = 'leads-su';
    protected const TRANSACTION_ID = 'transaction_id';

    public function parse(string $url): ?LeadInfo
    {
        $query = $this->getQueryParams($url);
        $isQueryValid = ($query['utm_source'] ?? null) === static::UTM_SOURCE
            && array_key_exists(static::TRANSACTION_ID, $query);

        if (!$isQueryValid) {
            return null;
        }

        return new LeadInfo(
            LeadSource::LEADS_SU,
            [
                'transactionId' => $query[static::TRANSACTION_ID]
            ]
        );
    }
}