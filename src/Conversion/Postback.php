<?php

namespace A1ex7\Cpa\Conversion;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Postback
{
    /** @var Request */
    protected $request;

    /** @var Response */
    protected $response;


    /**
     * Postback constructor.
     * @param Request $request
     * @param Response|null $response
     */
    public function __construct(Request $request, Response $response = null)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return Response|null
     */
    public function getResponse(): ?Response
    {
        return $this->response;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
}