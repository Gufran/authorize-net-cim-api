<?php namespace Gufran\AuthNet\Entities\RequestObjects;

use Gufran\AuthNet\Contracts\ObjectInterface;

abstract class BaseObject implements ObjectInterface {

    /**
     * Data to be converted into xml request
     * This is an associative array of tag => value
     * @var array
     */
    protected $data = array();

    /**
     * Methods supported by this class
     * array maps method name to respective element in XML
     * @var array
     */
    protected $methods = array();

    /**
     * get the data for an object in form of associative array
     *
     * @return array
     */
    public function getObjectData()
    {
        return $this->data;
    }

    /**
     * set refId on payload
     *
     * @param $refId
     *
     * @return $this
     */
    public function setRefId($refId)
    {
        $this->data['refId'] = $refId;

        return $this;
    }

    /**
     * @param $key
     * @param $value
     */
    protected function setData($key, $value)
    {
        $keys = explode('.', $key);
        $array = &$this->data;

        while (count($keys) > 1)
        {
            $key = array_shift($keys);

            if ( ! isset($array[$key]) || ! is_array($array[$key]))
            {
                $array[$key] = array();
            }

            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;
    }

    public function __call($name, $arguments)
    {
        if(substr($name, 0, 3) == 'set')
        {
            $method = lcfirst(substr($name, 3));

            if(in_array($method, array_keys($this->methods)))
            {
                $this->setData($this->methods[$method], $arguments[0]);
                return $this;
            }
        }

        throw new \BadMethodCallException('Method [' . $name . '] is not implemented on ' . get_class($this));
    }
}