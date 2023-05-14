<?php

namespace App\Common\Exceptions;

class ValidationException extends \Exception
{
    public function __construct(?string $message)
    {
        parent::__construct('Произошла ошибка при валидации данных для документа. ' . $message, 5);
    }
}
