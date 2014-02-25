<?php namespace Gufran\AuthNet\Entities\RequestMethods;

class GetProfile extends BaseMethod {

    /**
     * returns the name of the method to call on authorize CIM
     *
     * @return string
     */
    public function getMethodName()
    {
        return 'getCustomerProfileRequest';
    }
}