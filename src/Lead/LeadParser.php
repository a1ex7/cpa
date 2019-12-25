<?php


namespace A1ex7\Cpa\Lead;


interface LeadParser
{
    public function parse(string $url) :?LeadInfo;
}