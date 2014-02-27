<?php

use Gufran\AuthNet\API\Manager;

class ManagerTest extends PHPUnit_Framework_TestCase {

    public function test_returns_instance_of_delegate()
    {
        $config = Mockery::mock('Gufran\AuthNet\Entities\Configuration');
        $config->shouldReceive('isProduction')->andReturn(false);

        $manager = new Manager($config);

        $delegate = $manager->createProfile();

        $this->assertInstanceOf('\Gufran\AuthNet\API\Delegate', $delegate);
    }

    public function test_create_delegate_with_custom_objects()
    {
        $config = Mockery::mock('Gufran\AuthNet\Entities\Configuration');
        $config->shouldReceive('isProduction')->andReturn(false);

        $payload = Mockery::mock('Gufran\AuthNet\Contracts\ObjectInterface');
        $request = function() {
            throw new BadMethodCallException;
        };

        $manager = new Manager($config);

        $delegate = $manager->createDelegate($payload, $request);
        $this->assertInstanceOf('Gufran\AuthNet\API\Delegate', $delegate);
    }
}