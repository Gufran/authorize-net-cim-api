<?php namespace Gufran\AuthNet\Exceptions;

use Exception;

class InvalidApiPayloadException extends Exception {

    public function __construct($message, $code = 0, Exception $exception = null)
    {
        parent::__construct('Cannot initialize payload [' . $message . '] Unable to make request', $code, $exception);
    }
} 