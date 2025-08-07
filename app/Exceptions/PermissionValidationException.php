<?php

namespace App\Exceptions;

use Exception;

class PermissionValidationException extends Exception
{
    protected $errors;
    public function __construct($message, $errors = [])
    {
        parent::__construct($message);
        $this->errors = is_array($errors) ? $errors : ['general' => [$errors]];
    }
    public function getErrors()
    {
        return $this->errors;
    }
}
