<?php

namespace A1ex7\Cpa\Lead;

class LeadInfo
{
    /** @var string */
    protected $source;
    /** @var array */
    protected $config;

    public function __construct(string $source, array $config)
    {
        $this->source = $source;
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }
}