<?php

namespace A1ex7\Cpa\Providers\Credy;

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
     * @param EnvironmentConfig $config
     */
    public function __construct(EnvironmentConfig $config)
    {
        $this->config = $config;
    }


    protected function getRequest(Conversion $conversion, array $params): Request
    {
        $transactionId = $conversion->getConfig()['tid'] ?? null;
        $offer         = $this->config->getOffer($conversion->getProduct());
        $conversionId  = $conversion->getId();

        $queryParams = http_build_query([
            'offer_id'       => $offer,
            'transaction_id' => $transactionId,
            'adv_sub'        => $conversionId,
        ]);

        $url = "http://tracking.credy.eu/aff_lsr?{$queryParams}";

        return new Request('get', $url);
    }
}