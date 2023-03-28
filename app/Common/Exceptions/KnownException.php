<?php

namespace App\Common\Exceptions;

use Exception;

class KnownException extends Exception
{

    public function __construct(?string $message) {
        parent::__construct($message, 1);
    }

}
