<?php namespace Gufran\AuthNet\Exceptions;

use Exception;

class InvalidApiMethodException extends Exception {

    public function __construct($message, $code = 0, Exception $exception = null)
    {
        parent::__construct('Invalid API Method [' . $message . '] Unable to make request', $code, $exception);
    }
} 