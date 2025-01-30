<?php

namespace DevDizs\PayappWs\Exceptions;

use Exception;

final class ConnectionException extends Exception
{
    public function message()
    {
        return "Error trying to connect | {$this->getMessage()} | LINE: {$this->getLine()} | FILE: {$this->getFile()}";
    }
}