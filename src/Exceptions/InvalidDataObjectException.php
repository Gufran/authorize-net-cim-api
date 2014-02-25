<?php namespace Gufran\AuthNet\Exceptions;

use Exception;

class InvalidDataObjectException extends Exception {

    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
} 