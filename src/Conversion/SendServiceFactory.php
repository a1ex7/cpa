<?php


namespace A1ex7\Cpa\Conversion;

use A1ex7\Cpa;
use A1ex7\Cpa\Lead\LeadSource;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SendServiceFactory
{
    /**
     * @var array
     */
    private $senders;
    /**
     * @var string
     */
    private $source;
    /**
     * @var string
     */
    private $event;

    /**
     * SendServiceFactory constructor.
     * @param string $source
     * @param string $event
     */
    public function __construct(string $source, string $event)
    {
        $this->senders = [
            LeadSource::SALES_DOUBLER => [
                'class'  => Cpa\SalesDoubler\SendService::class,
                'config' => [
                    'class' => Cpa\SalesDoubler\EnvironmentConfig::class,
                ],
            ],
            LeadSource::DO_AFFILIATE => [
                'class'  => Cpa\DoAffiliate\SendService::class,
                'config' => [
                    'class' => Cpa\DoAffiliate\EnvironmentConfig::class,
                ],
            ],
            LeadSource::LEADS_SU => [
                'class'  => Cpa\LeadsSu\SendService::class,
                'config' => [
                    'class' => Cpa\LeadsSu\EnvironmentConfig::class,
                ],
            ],
            LeadSource::FIN_LINE => [
                'class'  => Cpa\FinLine\SendService::class,
                'config' => [
                    'class' => Cpa\FinLine\EnvironmentConfig::class,
                ],
            ],
            LeadSource::PAPA_KARLO => [
                'class'  => Cpa\PapaKarlo\SendService::class,
                'config' => [
                    'class' => Cpa\PapaKarlo\EnvironmentConfig::class,
                ],
            ],
            LeadSource::STORM_DIGITAL => [
                'class'  => Cpa\StormDigital\SendService::class,
                'config' => [
                    'class' => Cpa\StormDigital\EnvironmentConfig::class,
                ],
            ],
            LeadSource::ADMITAD => [
                'class'  => Cpa\AdmitAd\SendService::class,
                'config' => [
                    'class' => Cpa\AdmitAd\EnvironmentConfig::class,
                ],
            ],
            LeadSource::LEAD_GID => [
                'class'  => Cpa\LeadGid\SendService::class,
                'config' => [
                    'class' => Cpa\LeadGid\EnvironmentConfig::class,
                ],
            ],
            LeadSource::CREDY => [
                'class'  => Cpa\Credy\SendService::class,
                'config' => [
                    'class' => Cpa\Credy\EnvironmentConfig::class,
                ],
            ],
        ];
        $this->source = $source;
        $this->event = $event;
    }

    /**
     * @var SendServiceInterface $sender
     * @return SendServiceInterface|null
     */
    public function create()
    {
        if (!array_key_exists($this->source, $this->filteredSenders())) {
            Log::info("Trying to send conversion through disabled sender: $this->source");
            return null;
        }

        if ( !$this->hasEvent($this->source, $this->event) ) {
            Log::info("Event $this->event not found for $this->source");
            return null;
        }

        $config = app($this->senders[$this->source]['config']['class']);

        return app($this->senders[$this->source]['class'], compact('config'));
    }

    /**
     * @return array
     */
    private function filteredSenders()
    {
        return array_filter($this->senders, function ($sender, $source){
            return $this->shouldSend($source);
        }, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * @param $source
     * @param bool $default
     * @return mixed
     */
    private function shouldSend($source, $default = false)
    {
        $source = Str::snake($source);
        return Config::get('cpa.sources.' . $source, $default);
    }

    /**
     * @param $source
     * @param $event
     * @return bool
     */
    private function hasEvent($source, $event)
    {
        $source = Str::snake($source);
        return Config::has('cpa.events.' . $event . '.' . $source);
    }
}