<?php namespace Gufran\AuthNet\Entities\RequestObjects;


class CreatePaymentProfile extends BaseObject {

    /**
     * Methods supported by this class
     * array maps method name to respective element in XML
     * @var array
     */
    protected $methods = array(
        'customerProfileId' => 'customerProfileId',
        'firstName' => 'paymentProfile.billTo.firstName',
        'lastName' => 'paymentProfile.billTo.lastName',
        'company' => 'paymentProfile.billTo.company',
        'address' => 'paymentProfile.billTo.address',
        'city' => 'paymentProfile.billTo.city',
        'state' => 'paymentProfile.billTo.state',
        'zip' => 'paymentProfile.billTo.zip',
        'country' => 'paymentProfile.billTo.country',
        'phoneNumber' => 'paymentProfile.billTo.phoneNumber',
        'faxNumber' => 'paymentProfile.billTo.faxNumber',
        'cardNumber' => 'paymentProfile.payment.creditCard.cardNumber',
        'expirationDate' => 'paymentProfile.payment.creditCard.expirationDate'
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
        return $methodName == 'CreatePaymentProfile';
    }
}