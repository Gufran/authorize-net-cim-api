<?php namespace Gufran\AuthNet\Entities\RequestObjects;


class GetProfileIds extends BaseObject {

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
        return $methodName == 'GetProfileIds';
    }
}