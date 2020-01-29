<?php

namespace A1ex7\Cpa\Providers\LeadGid;

use A1ex7\Cpa\Interfaces\Conversion\SendServiceInterface;
use A1ex7\Cpa\Interfaces\Lead\LeadSource;
use A1ex7\Cpa\Models\Conversion;
use A1ex7\Cpa\Traits\SendServiceTrait;
use GuzzleHttp\Psr7\Request;

class SendService implements SendServiceInterface
{
    use SendServiceTrait;

    public $source = LeadSource::LEAD_GID;

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
        $advSub        = $conversion->getId();
        $transactionId = $conversion->getConfig()['click_id'] ?? null;
        $offerId       = $this->config->getOfferId($conversion->getProduct());

        $queryParams = http_build_query([
            'offer_id'       => $offerId,
            'adv_sub'        => $advSub,
            'transaction_id' => $transactionId,
        ]);

        $url = "{$this->getDomain()}/aff_lsr?{$queryParams}";

        return new Request('get', $url);
    }
}