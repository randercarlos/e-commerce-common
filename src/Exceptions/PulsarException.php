<?php

namespace Ecommerce\Common\Exceptions;

use Exception;

class PulsarException extends Exception
{
    public function __construct(string $message = "Error on Apache Pulsar", int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

