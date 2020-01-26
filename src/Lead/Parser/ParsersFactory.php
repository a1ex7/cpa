<?php


namespace A1ex7\Cpa\Lead\Parser;

use A1ex7\Cpa;
use A1ex7\Cpa\Lead\LeadParser;
use A1ex7\Cpa\Lead\LeadSource;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class ParsersFactory
{
    /**
     * @var array
     */
    private $parsers;

    /**
     * ParserFactory constructor.
     */
    public function __construct()
    {
        $this->parsers = [
            LeadSource::ADMITAD       => Cpa\AdmitAd\Lead\Parser::class,
            LeadSource::CREDY         => Cpa\Credy\Lead\Parser::class,
            LeadSource::DO_AFFILIATE  => Cpa\DoAffiliate\Lead\Parser::class,
            LeadSource::FIN_LINE      => Cpa\FinLine\Lead\Parser::class,
            LeadSource::LEAD_GID      => Cpa\LeadGid\Lead\Parser::class,
            LeadSource::LEADS_SU      => Cpa\LeadsSu\Lead\Parser::class,
            LeadSource::PAPA_KARLO    => Cpa\PapaKarlo\Lead\Parser::class,
            LeadSource::SALES_DOUBLER => Cpa\SalesDoubler\Lead\Parser::class,
            LeadSource::STORM_DIGITAL => Cpa\StormDigital\Lead\Parser::class,
            // add all needed parsers here
        ];
    }

    /**
     * @return array
     */
    public function create()
    {
        return array_map(static function ($parser): LeadParser {
            return app()->make($parser);
        }, $this->filteredParsers());
    }

    /**
     * @return array
     */
    private function filteredParsers()
    {
        return array_filter($this->parsers, function ($parser, $source){
            return $this->shouldParse($source);
        }, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * @param $source
     * @param bool $default
     * @return mixed
     */
    private function shouldParse($source, $default = false)
    {
        $source = Str::snake($source);
        return Config::get('cpa.sources.' . $source, $default);
    }
}