<?php namespace Gufran\AuthNet\Contracts;

interface ObjectInterface {

    /**
     * get the data for an object in form of associative array
     *
     * @return array
     */
    public function getObjectData();

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
    public function respondTo($methodName);

}