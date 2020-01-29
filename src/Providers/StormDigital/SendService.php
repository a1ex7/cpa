<?php

namespace A1ex7\Cpa\Providers\StormDigital;

use A1ex7\Cpa\Interfaces\Conversion\SendServiceInterface;
use A1ex7\Cpa\Interfaces\Lead\LeadSource;
use A1ex7\Cpa\Models\Conversion;
use A1ex7\Cpa\Traits\SendServiceTrait;
use GuzzleHttp\Psr7\Request;

class SendService implements SendServiceInterface
{
    use SendServiceTrait;

    public $source = LeadSource::STORM_DIGITAL;

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

        $url = "{$this->getDomain()}/postback?{$queryParams}";

        return new Request('get', $url);
    }
}