<?php

use Gufran\AuthNet\API\Delegate;

class DelegateTest extends PHPUnit_Framework_TestCase {

    private $object;

    private $mockRequest;

    private $request;

    private $delegate;

    private $engine;

    public function setUp()
    {
        $this->object = Mockery::mock('Gufran\AuthNet\Contracts\ObjectInterface');
        $this->mockRequest = Mockery::mock('Gufran\AuthNet\Contracts\MethodInterface');
        $this->engine = Mockery::mock('Gufran\AuthNet\Services\Request');

        $mockRequest = $this->mockRequest;
        $this->request = function ($object) use ($mockRequest) {
            return $mockRequest;
        };

        $this->delegate = new Delegate($this->object, $this->request, $this->engine);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function test_set_method_calls_are_passed_to_payload_object()
    {
        $this->object->shouldReceive('setCustomerId')
            ->with('1001')
            ->once()
            ->andReturn(null);

        $result = $this->delegate->setCustomerId('1001');

        $this->assertInstanceOf('Gufran\AuthNet\API\Delegate', $result);
    }

    public function test_get_method_invokes_api_request()
    {
        $mockResponse = Mockery::mock('Gufran\AuthNet\Services\Response');

        $mockResponse->shouldReceive('getCustomerAddressId')
            ->once()
            ->andReturn('30000');

        $mockResponse->shouldReceive('get')
            ->once()
            ->with('token')
            ->andReturn('token');

        $this->engine->shouldReceive('make')
            ->with($this->mockRequest)
            ->once()
            ->andReturn($mockResponse);

        $result = $this->delegate->getCustomerAddressId();
        $this->assertEquals('30000', $result);

        $token = $this->delegate->get('token');
        $this->assertEquals('token', $token);
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function test_it_can_handle_only_get_and_set_magic_method_calls()
    {
        $this->delegate->makeSomething();
    }
}