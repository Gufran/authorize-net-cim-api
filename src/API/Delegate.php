<?php namespace Gufran\AuthNet\API;

use Gufran\AuthNet\Contracts\ObjectInterface;
use Gufran\AuthNet\Services\Request;

class Delegate {

    private $payload = null;

    private $requestMethod = null;

    private $engine = null;

    private $response = null;

    public function send()
    {
        $dataGenerator = call_user_func($this->requestMethod, $this->payload);
        $this->response = $this->engine->make($dataGenerator);
        return $this->response;
    }

    public function __construct(ObjectInterface $payload, callable $requestMethod, Request $engine)
    {
        $this->payload = $payload;
        $this->requestMethod = $requestMethod;
        $this->engine = $engine;
    }

    public function __call($method, $arguments)
    {
        if(substr($method, 0, 3) === 'set')
        {
            $this->payload->$method($arguments[0]);
            return $this;
        }
        elseif(substr($method, 0, 3) === 'get')
        {
            return $this->manageResponse($method, $arguments);
        }

        throw new \BadMethodCallException('Method [' . $method . '] is not implemented by API Delegate');
    }

    private function manageResponse($method, array $args)
    {
        if(is_null($this->response)) $this->send();

        if(count($args) == 0)
        {
            return $this->response->$method();
        }
        else
        {
            return $this->response->$method($args[0]);
        }
    }
}