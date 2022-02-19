<?php

declare(strict_types=1);

namespace DevRecord\Domain\Common\Validation;

use DevRecord\Domain\Common\Validation\Error\ValidateErrors;
use DevRecord\Domain\Common\Validation\Error\ValidateException;
use DevRecord\Domain\Common\Validation\Rule\Rule;

final class Validator
{
    private ValidateErrors $errors;

    /**
     * @param array  $originals
     * @param Rule[] $rules
     */
    public function __construct(
        private array $originals,
        private array $rules,
    ) {
        $this->errors = new ValidateErrors([]);
    }

    public function validate(): void
    {
        if (!$this->passes()) {
            throw new ValidateException($this->errors);
        }

        return;
    }

    public function passes(): bool
    {
        foreach ($this->originals as $property => $data) {
            if (!array_key_exists($property, $this->rules)) {
                continue;
            }
            foreach ($this->rules[$property] as $rule) {
                /** @var Rule $rule */
                if (!$rule->isPass($data)) {
                    $this->errors = $this->errors->addError($property, $rule->errorMessage());
                };
            }
        }

        return !$this->errors->failed();
    }

    public function getErrors(): ValidateErrors
    {
        return $this->errors;
    }
}
