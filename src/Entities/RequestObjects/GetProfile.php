<?php namespace Gufran\AuthNet\Entities\RequestObjects;


class GetProfile extends BaseObject {

    protected $methods = array(
        'profileId' => 'customerProfileId'
    );

    /**
     * check if the Object respond to a certain type of request method
     *
     * for example a `CreditCard` object alone does not respond to any method
     * but a `CustomerProfile` object having `CreditCard` inside it does
     * respond to `CreateCustomerProfileRequest`
     *
     * @param $methodName
     *
     * @return boolean
     */
    public function respondTo($methodName)
    {
        return $methodName == 'GetProfile';
    }
}