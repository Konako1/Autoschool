<?php

namespace App\Common\Exceptions;

use Exception;

class DataBaseException extends Exception
{
    public function __construct(?string $message)
    {
        parent::__construct('Произошла ошибка при работе с базой данных. ' . $message, 6);
    }
}
