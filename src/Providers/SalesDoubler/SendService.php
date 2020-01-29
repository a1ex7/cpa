<?php

namespace A1ex7\Cpa\Providers\SalesDoubler;

use A1ex7\Cpa\Interfaces\Conversion\SendServiceInterface;
use A1ex7\Cpa\Interfaces\Lead\LeadSource;
use A1ex7\Cpa\Models\Conversion;
use A1ex7\Cpa\Traits\SendServiceTrait;
use GuzzleHttp\Psr7\Request;

class SendService implements SendServiceInterface
{
    use SendServiceTrait;

    public $source = LeadSource::SALES_DOUBLER;

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


    protected function getRequest(Conversion $conversion): Request
    {
        $clickId = $conversion->getConfig()['clickId'] ?? null;
        $transId = $conversion->getId();
        $affId = $conversion->getConfig()['aid'] ?? null;
        $token = $this->config->getToken($conversion->getProduct());
        $id = $this->config->getId($conversion->getProduct());

        $url = "{$this->getDomain()}/in/postback/{$id}/{$clickId}?trans_id={$transId}&aff_id={$affId}&token={$token}";

        return new Request('get', $url);
    }
}