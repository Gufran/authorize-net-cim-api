<?php

use Gufran\AuthNet\Services\Request;

class RequestTest extends PHPUnit_Framework_TestCase {

    private $config;

    private $service;

    private $guzzle;

    private $method;

    public function setUp()
    {
        parent::setUp();

        $this->config = Mockery::mock('Gufran\AuthNet\Entities\Configuration');
        $this->guzzle = Mockery::mock('Guzzle\Http\Client');

        $this->config->shouldReceive('isProduction')
            ->andReturn(false);

        $this->guzzle->shouldReceive('post')
            ->with('https://apitest.authorize.net/xml/v1/request.api')
            ->andReturn(Mockery::self());

        /** @noinspection PhpParamsInspection */
        $this->service = new Request($this->config, $this->guzzle);

        $this->method = Mockery::mock('Gufran\AuthNet\Contracts\MethodInterface');
    }

    public function test_it_can_make_valid_request()
    {
        $requestPayload = '<?xml version="1.0" encoding="utf-8"?>
<createCustomerShippingAddressRequest>
 <merchantAuthentication>
 <name>YourUserLogin</name>
 <transactionKey>YourTranKey</transactionKey>
 </merchantAuthentication>
 <customerProfileId>10000</customerProfileId>
 <address>
 <firstName>John</firstName>
 <lastName>Doe</lastName>
 <company></company>
 <address>123 Main St.</address>
 <city>Bellevue</city>
 <state>WA</state>
 <zip>98004</zip>
 <country>USA</country>
 <phoneNumber>000-000-0000</phoneNumber>
 <faxNumber></faxNumber>
 </address>
</createCustomerShippingAddressRequest>';

        $responseXml = '<?xml version="1.0" encoding="utf-8"?>
<createCustomerShippingAddressResponse>
 <messages>
 <resultCode>Ok</resultCode>
 <message>
 <code>I00001</code>
 <text>Successful.</text>
 </message>
 </messages>
 <customerAddressId>30000</customerAddressId>
</createCustomerShippingAddressResponse>';

        $this->config->shouldReceive('getLoginId')
            ->andReturn('username');

        $this->config->shouldReceive('getTransactionKey')
            ->andReturn('transactionKey');

        $this->method->shouldReceive('setAuthentication')
            ->with('username', 'transactionKey')
            ->andReturn(Mockery::self());

        $this->method->shouldReceive('getFormattedXml')
            ->andReturn($requestPayload);

        $this->guzzle->shouldReceive('setBody')
            ->with($requestPayload)
            ->andReturn(Mockery::mock(array('send' => Mockery::mock(array('getBody' => $responseXml)))));

        $result = $this->service->make($this->method);

        $this->assertInstanceOf('Gufran\AuthNet\Services\Response', $result);
    }

    public function tearDown()
    {
        Mockery::close();
    }
} 