<?php

namespace A1ex7\Cpa\Lead\Parser;

use A1ex7\Cpa\Lead\LeadInfo;
use A1ex7\Cpa\Lead\LeadParser;

class Chain implements LeadParser
{

    public $parsers;

    /**
     * Chain constructor.
     */
    public function __construct()
    {
        $this->parsers = (new ParsersFactory())->create();
    }

    public function parse(string $url): ?LeadInfo
    {
        foreach ($this->parsers as $parser) {
            $leadInfo = $parser->parse($url);
            if ($leadInfo instanceof LeadInfo) {
                return $leadInfo;
            }
        }

        return null;
    }
}