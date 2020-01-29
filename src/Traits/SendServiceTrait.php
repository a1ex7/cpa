<?php

namespace A1ex7\Cpa\Traits;

use A1ex7\Cpa\Conversion\Postback;
use A1ex7\Cpa\Models\Conversion;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

trait SendServiceTrait
{
    /*
     * CPA Network source
     *
     * */
    public $source;
    /**
     * @param  Conversion  $conversion
     * @param  array  $params
     * @return Postback
     */
    final public function send(Conversion $conversion, array $params = []): Postback
    {
        $client = new Client();
        $request = $this->getRequest($conversion, $params);

        try {
            $response = $client->send($request);
        } catch (RequestException $e) {
            return new Postback($request, $e->getResponse());
        } catch (GuzzleException $e) {
            return new Postback($request);
        }

        return new Postback($request, $response);
    }

    /**
     * Get CPA network source domain from config
     *
     * @return string
     */
    public function getDomain(): string
    {
        return Config::get(Str::snake($this->getSource()));
    }

    abstract protected function getRequest(Conversion $conversion, array $params): Request;

    /**
     * Get CPA Network source string
     *
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

}