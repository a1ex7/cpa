<?php


namespace A1ex7\Cpa\Interfaces\Lead;


use A1ex7\Cpa\Lead\LeadInfo;

interface LeadParser
{
    public function parse(string $url) :?LeadInfo;
}