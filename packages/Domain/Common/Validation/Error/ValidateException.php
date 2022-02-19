<?php

declare(strict_types=1);

namespace DevRecord\Domain\Common\Validation\Error;

use Exception;

final class ValidateException extends Exception
{
    public function __construct(
        private ValidateErrors $errors,
    ) {
        parent::__construct();
    }

    public function errors(): ValidateErrors
    {
        return $this->errors;
    }
}
