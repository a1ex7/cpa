<?php

namespace A1ex7\Cpa\LeadsSu;

use A1ex7\Cpa\Conversion\SendServiceInterface;
use A1ex7\Cpa\Conversion\SendServiceTrait;
use A1ex7\Cpa\Models\Conversion;
use GuzzleHttp\Psr7\Request;

class SendService implements SendServiceInterface
{
    use SendServiceTrait;

    public const STATUS_REJECTED = 'rejected';
    public const STATUS_PENDING  = 'pending';
    public const STATUS_APPROVED = 'approved';

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
        $transactionId = $conversion->getConfig()['transactionId'] ?? null;
        $token         = $this->config->getToken($conversion->getProduct());
        $conversionId  = $conversion->getId();

        $goal   = $params['goal'] ?? $this->config->getGoal($conversion->getProduct());
        $status = $params['status'] ?? self::STATUS_APPROVED;

        $queryParams = http_build_query([
            'token'          => $token,
            'goal_id'        => $goal,
            'transaction_id' => $transactionId,
            'adv_sub'        => $conversionId,
            'status'         => $status,
        ]);

        $url = "http://api.leads.su/advertiser/conversion/createUpdate?{$queryParams}";

        return new Request('get', $url);
    }
}