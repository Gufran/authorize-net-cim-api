<?php

use Gufran\AuthNet\Services\Response;

class ResponseTest extends PHPUnit_Framework_TestCase {

    private $xml;

    private $response;

    public function setUp()
    {
        parent::setUp();

        $this->xml = '<?xml version="1.0" encoding="utf-8"?>
<createCustomerProfileTransactionResponse>
 <messages>
 <resultCode>Ok</resultCode>
 <message>
 <code>I00001</code>
 <text>Successful.</text>
 </message>
 </messages>
 <customerProfileId>1001</customerProfileId>
 <token>heyIAmAToken</token>
 <directResponse>directResponse</directResponse>
</createCustomerProfileTransactionResponse>';

        $this->response = new Response(simplexml_load_string($this->xml));
    }

    public function test_it_can_parse_response()
    {
        $this->assertTrue($this->response->isValid());

        $this->assertFalse($this->response->isInvalid());
    }

    public function test_it_can_fetch_token()
    {
        $this->assertEquals('heyIAmAToken', $this->response->getToken());
    }

    public function test_it_can_fetch_customer_profile_if()
    {
        $this->assertSame('1001', $this->response->getProfileId());
    }

    public function test_it_fetches_valid_result_via_get_method()
    {
        $this->assertSame($this->response->getToken(), $this->response->get('token'));
        $this->assertSame($this->response->get('messages.resultCode'), 'Ok');
    }

    public function test_get_method_can_return_default_value()
    {
        $this->assertSame($this->response->get('something', 'hello'), 'hello');
    }

    public function tearDown()
    {
        Mockery::close();
    }
} 