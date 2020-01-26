<?php

namespace A1ex7\Cpa\Providers\DoAffiliate;

use A1ex7\Cpa\Conversion\SendServiceInterface;
use A1ex7\Cpa\Conversion\SendServiceTrait;
use A1ex7\Cpa\Models\Conversion;
use GuzzleHttp\Psr7\Request;

class SendService implements SendServiceInterface
{
    use SendServiceTrait;
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

        $url = "http://tracker2.doaffiliate.net/api/{$path}?{$queryParams}";

        return new Request('get', $url);
    }
}