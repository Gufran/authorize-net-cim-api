<?php

use Gufran\AuthNet\Entities\RequestObjects\CreatePaymentProfile;

class CreatePaymentProfileTest extends PHPUnit_Framework_TestCase {

    private $object;

    public function setUp()
    {
        $this->object = new CreatePaymentProfile();
    }

    public function test_can_set_ref_id()
    {
        $this->object->setRefId('101010');

        $result = $this->object->getObjectData();

        $this->assertEquals($result['refId'], '101010');
    }

    public function test_can_accept_defined_method_calls_and_data()
    {
        $this->object->setFirstName('gufran');
        $this->object->setCity('my city');
        $this->object->setCustomerProfileId('123');

        $result = $this->object->getObjectData();

        $expected = array(
            'customerProfileId' => '123',
            'paymentProfile' => array(
                'billTo' => array(
                    'firstName' => 'gufran',
                    'city' => 'my city'
                )
            )
        );

        $this->assertEquals($result, $expected);
    }

    /**
     * @expectedException BadMethodCallException
     */
    public function test_do_not_accept_undefined_method_calls()
    {
        $this->object->setSomeThing('value');
    }

}