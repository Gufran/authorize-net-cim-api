<?php namespace Gufran\AuthNet\Services;

use Gufran\AuthNet\Contracts\MethodInterface;
use Gufran\AuthNet\Entities\Configuration;
use Guzzle\Http\Client;

class Request {

    const DEV_URL = 'https://apitest.authorize.net/xml/v1/request.api';

    const PRODUCTION_URL = 'https://api.authorize.net/xml/v1/request.api';

    private $config;

    private $engine;

    public function __construct(Configuration $config, Client $client)
    {
        $this->config = $config;

        $url = $this->config->isProduction() ? self::PRODUCTION_URL : self::DEV_URL;
        $this->engine = $client->post($url);
    }

    public function make(MethodInterface $method)
    {
        $payload = $method->setAuthentication(
                          $this->config->getLoginId(), $this->config->getTransactionKey()
        )->getFormattedXml();

        $results = $this->makeRequest($payload);

        return $results;
    }

    private function makeRequest($payload)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $response = $this->engine
                        ->setBody($payload)
                        ->send();

        $result = str_replace('xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd"', '', $response->getBody());

        /** @noinspection PhpUndefinedMethodInspection */
        return new Response(simplexml_load_string($result));
    }
} 