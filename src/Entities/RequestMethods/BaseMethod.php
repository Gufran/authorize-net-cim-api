<?php namespace Gufran\AuthNet\Entities\RequestMethods;

use ErrorException;
use Gufran\AuthNet\Contracts\MethodInterface;
use Gufran\AuthNet\Contracts\ObjectInterface;
use Gufran\AuthNet\Exceptions\InvalidDataObjectException;
use SimpleXMLElement;

abstract class BaseMethod implements MethodInterface {

    /**
     * @var SimpleXMLElement
     */
    protected $xmlObject = null;

    /**
     * xml namespace
     * @var string
     */
    protected $xmlNamespace = 'AnetApi/xml/v1/schema/AnetApiSchema.xsd';

    /**
     * check if the method is ready to be fired
     * @var boolean
     */
    private $ready = false;

    /**
     * returns the name of the method to call on authorize CIM
     *
     * @return string
     */
    abstract public function getMethodName();

    /**
     * instantiate the object
     *
     * @param ObjectInterface $model
     *
     * @throws \Gufran\AuthNet\Exceptions\InvalidDataObjectException
     */
    public function __construct(ObjectInterface $model)
    {
        $methodName = $this->getMethodName();

        if( ! $model->respondTo($methodName) or ! $model->respondTo(get_class($this))) {
            throw new InvalidDataObjectException(
                'Object ' . get_class($model) . ' does not respond to method ' . $methodName
            );
        }

        $xml = $this->getXmlScaffolding($methodName);
        $this->setParams($model, $xml);
    }

    /**
     * static method to create method object
     *
     * @param ObjectInterface $model
     *
     * @return static
     */
    public static function make(ObjectInterface $model)
    {
        return new static($model);
    }

    /**
     * set authentication credentials for request
     *
     * @param $name
     * @param $transactionKey
     *
     * @return $this
     */
    public function setAuthentication($name, $transactionKey)
    {
        $credentials = array(
            'merchantAuthentication' => compact('name', 'transactionKey')
        );

        $this->xmlObject = $this->arrayToXml($credentials, $this->xmlObject);

        $this->ready = true;

        return $this;
    }

    /**
     * get the formatted xml data
     * @throws ErrorException
     * @return string
     */
    public function getFormattedXml()
    {
        if($this->ready == false)
            throw new ErrorException('No authentication credentials available. XML Payload requested without credentials');

        return $this->xmlObject->toXml();
    }

    /**
     * set parameters on xml element
     *
     * @param ObjectInterface  $model
     * @param SimpleXMLElement $xml
     */
    protected function setParams(ObjectInterface $model, SimpleXMLElement $xml)
    {
        $this->xmlObject = $this->arrayToXml($model->getObjectData(), $xml);
    }

    /**
     * convert associative array into xml object
     *
     * @param array            $data
     * @param SimpleXMLElement $xmlObject
     *
     * @return SimpleXMLElement
     */
    protected function arrayToXml(array $data, SimpleXMLElement $xmlObject)
    {
        foreach ($data as $param => $value) {
            if(empty($value)) continue;

            if (is_array($value)) {
                // if value is not an associative array we will create
                // multiple children with same name as $param

                if($this->isAssociativeArray($value)) {
                    $xmlObject->addChild($param);
                    $this->arrayToXml($value, $xmlObject->$param);
                } else {
                    foreach($value as $element) {
                        $newChild = $xmlObject->addChild($param);
                        $this->arrayToXml($element, $newChild);
                    }
                }
            } elseif ($value instanceof ObjectInterface) {
                // If value is an Object of RequestObject we will append it to the xml
                $xmlObject->addChild($param);
                $this->arrayToXml($value->getObjectData(), $xmlObject->$param);
            } else {
                $xmlObject->$param = $value;
            }
        }

        return $xmlObject;
    }

    /**
     * @param string
     * @return SimpleXMLElement
     */
    protected function getXmlScaffolding($method)
    {
        $xml = '<?xml version="1.0" encoding="utf-8"?>'.
            '<' . $method . ' xmlns="' . $this->xmlNamespace . '">'.
            '</' . $method . '>';

        return simplexml_load_string($xml);
    }

    /**
     * a helper method to check if array is associative
     * and therefore valid for xml creation
     *
     * @param array $data
     *
     * @return bool
     */
    private function isAssociativeArray(array $data)
    {
        foreach(array_keys($data) as $key) {
            if(is_numeric($key)) return false;
        }

        return true;
    }
}