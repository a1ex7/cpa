<?php

namespace A1ex7\Cpa\Providers\PapaKarlo;

use A1ex7\Cpa\Interfaces\Conversion\SendServiceInterface;
use A1ex7\Cpa\Models\Conversion;
use A1ex7\Cpa\Traits\SendServiceTrait;
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
     * @param  EnvironmentConfig  $config
     */
    public function __construct(EnvironmentConfig $config)
    {
        $this->config = $config;
    }


    /**
     * @param  Conversion  $conversion
     * @param  array  $params  ['type' => 'offer|goal', 'offer_id' => 'numeric', 'goal_id' => 'numeric']
     * @return Request
     */
    public function getRequest(Conversion $conversion, array $params): Request
    {
        $clickId = $conversion->getConfig()['clickId'] ?? null;
        $transId = $conversion->getId();
        $type    = $params['type'] ?? $this->config->getType($conversion->getProduct());
        $offerId = $params['offer_id'] ?? $this->config->getOffer($conversion->getProduct());
        $goalId  = $params['goal_id'] ?? $this->config->getGoal($conversion->getProduct());
        $path    = ($type === 'offer') ? 'aff_lsr' : 'aff_goal';

        $queryParams = http_build_query([
            'a'              => 'lsr',
            'offer_id'       => $offerId,
            'goal_id'        => $goalId,
            'adv_sub'        => $transId,
            'transaction_id' => $clickId,
        ]);

        $url = "http://targetme.go2cloud.org/{$path}?{$queryParams}";

        return new Request('get', $url);
    }
}