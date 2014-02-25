<?php namespace Gufran\AuthNet\Services;

use Gufran\AuthNet\Contracts\MethodInterface;
use Gufran\AuthNet\Entities\Configuration;
use Gufran\AuthNet\Exceptions\InvalidRequestException;

class Request {

    const DEV_URL = 'https://apitest.authorize.net/xml/v1/request.api';

    const PRODUCTION_URL = 'https://api.authorize.net/xml/v1/request.api';

    private $config;

    public function __construct(Configuration $config)
    {
        $this->config = $config;

        $url = $this->config->isProduction() ? self::PRODUCTION_URL : self::DEV_URL;
        $this->engine = curl_init($url);
    }

    public function __destruct()
    {
        curl_close($this->engine);
    }

    public function make(MethodInterface $method)
    {
        $payload = $method->setAuthentication(
                          $this->config->getLoginId(), $this->config->getTransactionKey()
        )->getFormattedXml();

        $results = $this->makeRequest($payload);

        return $results;
    }

    public function makeRequest($payload)
    {
        curl_setopt($this->engine, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->engine, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($this->engine, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($this->engine, CURLOPT_SSL_VERIFYPEER, 1);
        $response = curl_exec($this->engine);

        if ($response === false)
        {
            throw new InvalidRequestException('An error occurred while making API request to Authorize Net - ' . curl_error($this->engine));
        }

        return new Response(simplexml_load_string($response));
    }
} 