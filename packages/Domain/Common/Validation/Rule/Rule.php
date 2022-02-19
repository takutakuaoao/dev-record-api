<?php

namespace DevRecord\Domain\Common\Validation\Rule;

interface Rule
{
    public function isPass($data): bool;
    public function errorMessage(): string;
}
