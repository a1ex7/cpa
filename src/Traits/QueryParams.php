<?php

namespace A1ex7\Cpa\Traits;

trait QueryParams
{
    /**
     * @param string $url
     * @return array
     */
    protected function getQueryParams(string $url): array
    {
        $queryString = parse_url($url, PHP_URL_QUERY) ?? '';
        parse_str($queryString, $output);

        return $output;
    }
}