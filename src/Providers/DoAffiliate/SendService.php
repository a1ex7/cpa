<?php

namespace A1ex7\Cpa\Providers\DoAffiliate;

use A1ex7\Cpa\Interfaces\Conversion\SendServiceInterface;
use A1ex7\Cpa\Interfaces\Lead\LeadSource;
use A1ex7\Cpa\Models\Conversion;
use A1ex7\Cpa\Traits\SendServiceTrait;
use GuzzleHttp\Psr7\Request;

class SendService implements SendServiceInterface
{
    use SendServiceTrait;

    public $source = LeadSource::DO_AFFILIATE;

    /**
     * @var EnvironmentConfig
     */
    protected $config;

    /**
     * SendService constructor.
     * @param EnvironmentConfig $config
     */
    public function __construct(EnvironmentConfig $config)
    {
        $this->config = $config;
    }


    protected function getRequest(Conversion $conversion, array $params): Request
    {
        $visitor  = $conversion->getConfig()['visitor'] ?? null;
        $path = $this->config->getPath($conversion->getProduct());
        $type = $params['type'] ?? 'CPA';

        $queryParams = http_build_query([
            'type' => $type,
            'lead' => $conversion->getId(),
            'v'    => $visitor,
        ]);

        $url = "{$this->getDomain()}/api/{$path}?{$queryParams}";

        return new Request('get', $url);
    }
}