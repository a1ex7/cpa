<?php

namespace A1ex7\Cpa\Providers\AdmitAd;

use A1ex7\Cpa\Interfaces\Conversion\SendServiceInterface;
use A1ex7\Cpa\Models\Conversion;
use A1ex7\Cpa\Traits\SendServiceTrait;
use GuzzleHttp\Psr7\Request;

class SendService implements SendServiceInterface
{
    use SendServiceTrait;

    const PAYMENT_TYPE_SALE = 'sale';
    const PAYMENT_TYPE_LEAD = 'lead';

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
        $uid = $conversion->getConfig()['uid'] ?? null;

        $queryParams = http_build_query([
            'order_id'      => $conversion->getId(),
            'campaign_code' => $this->config->getCampaignCode($conversion->getProduct()),
            'uid'           => $uid,
            'postback'      => 1,
            'postback_key'  => $this->config->getPostbackKey($conversion->getProduct()),
            'action_code'   => $params['action_code'] ?? $this->config->getActionCode($conversion->getProduct()),
            'tariff_code'   => $params['tariff_code'] ?? $this->config->getTariffCode($conversion->getProduct()),
            'payment_type'  => $params['payment_type'] ?? self::PAYMENT_TYPE_SALE,
        ]);

        $url = "https://ad.admitad.com/r?{$queryParams}";

        return new Request('get', $url);
    }
}