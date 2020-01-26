<?php

namespace A1ex7\Cpa\Providers\StormDigital;

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
        $clickId  = $conversion->getConfig()['clickId'] ?? null;
        $actionId = $conversion->getId();
        $secure   = $this->config->getSecure($conversion->getProduct());
        $goal = $params['goal'] ?? $this->config->getGoal($conversion->getProduct());

        $queryParams = http_build_query([
            'clickid'   => $clickId,
            'action_id' => $actionId,
            'goal'      => $goal,
            'secure'    => $secure,
        ]);

        $url = "http://offers.stormdigital.affise.com/postback?{$queryParams}";

        return new Request('get', $url);
    }
}