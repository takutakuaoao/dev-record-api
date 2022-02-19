<?php

declare(strict_types=1);

namespace DevRecord\Domain\Common;

final class Id
{
    public function __construct(
        private string $value,
    ) {
    }

    static public function issueNew(): self
    {
        return (new Id(uniqid()));
    }

    public function equal(Id $id): bool
    {
        return $this->value === $id->value;
    }

    public function toDto(): IdDto
    {
        return (new IdDto($this->value));
    }

    public function toJson(): array
    {
        return [
            'id' => $this->value,
        ];
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
