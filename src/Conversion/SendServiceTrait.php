<?php

namespace A1ex7\Cpa\Conversion;

use A1ex7\Cpa\Models\Conversion;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

trait SendServiceTrait
{
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

    abstract protected function getRequest(Conversion $conversion, array $params): Request;

}