<?php

namespace A1ex7\Cpa\Providers\SalesDoubler;

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


    protected function getRequest(Conversion $conversion): Request
    {
        $clickId = $conversion->getConfig()['clickId'] ?? null;
        $transId = $conversion->getId();
        $affId = $conversion->getConfig()['aid'] ?? null;
        $token = $this->config->getToken($conversion->getProduct());
        $id = $this->config->getId($conversion->getProduct());
        $url = "http://rdr.salesdoubler.com.ua/in/postback/{$id}/{$clickId}?trans_id={$transId}&aff_id={$affId}&token={$token}";

        return new Request('get', $url);
    }
}