<?php namespace Gufran\AuthNet\Entities\RequestObjects;


class CreateProfile extends BaseObject {

    /**
     * Methods supported by this class
     * array maps method name to respective element in XML
     * @var array
     */
    protected $methods = array(
        'merchantCustomerId' => 'profile.merchantCustomerId',
        'description' => 'profile.description',
        'email' => 'profile.email',
        'paymentProfiles' => 'profile.paymentProfiles'
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
        return $methodName == 'CreateProfile';
    }
}