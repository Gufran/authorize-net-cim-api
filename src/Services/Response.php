<?php namespace Gufran\AuthNet\Services;


use SimpleXMLElement;

class Response {

    /**
     * @var SimpleXMLElement
     */
    private $result;

    public function __construct(SimpleXMLElement $result)
    {
        $this->result = $result;
    }

    /**
     * @return bool
     */
    public function isOk()
    {
        return ((string)($this->result->messages->resultCode) == 'Ok');
    }

    /**
     * @return bool
     */
    public function isInvalid()
    {
        return (! $this->isOk());
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return (string) ($this->result->token);
    }

    /**
     * @return string
     */
    public function getProfileId()
    {
        return (string) ($this->result->customerProfileId);
    }

    /**
     * a dot notation string to fetch element
     *
     * @param      $key
     * @param null $default
     *
     * @return null|SimpleXMLElement|\SimpleXMLElement[]|string
     */
    function get($key, $default = null)
    {
        $object = $this->result;

        if (is_null($key) or trim($key) == '') return $object;

        foreach (explode('.', $key) as $segment)
        {
            if ( ! is_object($object) || ! isset($object->{$segment}))
            {
                return $default;
            }

            $object = $object->{$segment};
        }

        return (string) $object;
    }
}