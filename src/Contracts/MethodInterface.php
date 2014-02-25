<?php namespace Gufran\AuthNet\Contracts;

interface MethodInterface {

    /**
     * @param $loginId
     * @param $transactionKey
     *
     * @return mixed
     */
    public function setAuthentication($loginId, $transactionKey);

    /**
     * get the formatted xml data
     * @return string
     */
    public function getFormattedXml();
} 