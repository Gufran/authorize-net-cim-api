<?php namespace Gufran\AuthNet\Entities\RequestObjects;


class CreateShippingAddress extends BaseObject {

    /**
     * Methods supported by this class
     * array maps method name to respective element in XML
     * @var array
     */
    protected $methods = array(
        'firstName' => 'address.firstName',
        'lastName' => 'address.lastName',
        'company' => 'address.company',
        'address' => 'address.address',
        'city' => 'address.city',
        'state' => 'address.state',
        'zip' => 'address.zip',
        'country' => 'address.country',
        'phoneNumber' => 'address.phoneNumber',
        'faxNumber' => 'address.faxNumber',
    );

    /**
     * check if the Object respond to a certain type of request method
     *
     * @param $methodName
     *
     * @return boolean
     */
    public function respondTo($methodName)
    {
        return $methodName == 'CreateShippingAddress';
    }
}