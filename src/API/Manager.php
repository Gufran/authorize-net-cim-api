<?php namespace Gufran\AuthNet\API;

use Gufran\AuthNet\Contracts\ObjectInterface;
use Gufran\AuthNet\Entities\Configuration;
use Gufran\AuthNet\Exceptions\InvalidApiMethodException;
use Gufran\AuthNet\Exceptions\InvalidApiPayloadException;
use Gufran\AuthNet\Services\Request;

class Manager {

    protected $namespace = 'Gufran\\AuthNet\\Entities';

    private $configuration;

    public function __construct(Configuration $config)
    {
        $this->configuration = $config;
        $this->requestEngine = new Request($config);
    }

    public function createDelegate(ObjectInterface $payload, callable $request)
    {
        return new Delegate($payload, $request, $this->requestEngine);
    }

    public function __call($method, $arguments)
    {
        $class = ucfirst($method);

        $objects = $this->createObjects($class);

        return $this->createDelegate($objects['payload'], $objects['request']);
    }

    private function createObjects($requestName, $namespace = null)
    {
        if(is_null($namespace)) $namespace = $this->namespace;

        $methodClass = $namespace . '\\RequestMethods\\' . $requestName;
        $objectClass = $namespace . '\\RequestObjects\\' . $requestName;

        if(!class_exists($methodClass))
            throw new InvalidApiMethodException($methodClass);

        if(!class_exists($objectClass))
            throw new InvalidApiPayloadException($objectClass);

        $payloadObject = new $objectClass();

        if(! (in_array('Gufran\AuthNet\Contracts\MethodInterface', class_implements($methodClass))))
            throw new InvalidApiMethodException($methodClass . ' Must implement MethodInterface');

        $methodObject = function($payload) use($methodClass) {
            return new $methodClass($payload);
        };

        if( ! ($payloadObject instanceof \Gufran\AuthNet\Contracts\ObjectInterface))
            throw new InvalidApiPayloadException($objectClass . ' Must implement ObjectInterface');

        return array('request' => $methodObject, 'payload' => $payloadObject);
    }
}