<?php

namespace src\Product\Domain\Exceptions;

use Exception;

class ProductException extends Exception
{
    protected $message = 'Product error';
    protected $code = 400;

    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        if (!empty($message)) {
            $this->message = $message;
        }

        if (!empty($code)) {
            $this->code = $code;
        }

        parent::__construct($this->message, $this->code, $previous);
    }
}
