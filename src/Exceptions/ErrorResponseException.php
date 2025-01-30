<?php

namespace DevDizs\PayappWs\Exceptions;

use Exception;

final class ErrorResponseException extends Exception
{
    public function message()
    {
        return "Error Response | MESSAGE: {$this->getMessage()} | LINE: {$this->getLine()} | FILE: {$this->getFile()}";
    }
}