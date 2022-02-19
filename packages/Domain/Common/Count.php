<?php

declare(strict_types=1);

namespace DevRecord\Domain\Common;

final class Count
{
    private function __construct(
        private int $count
    ) {
    }

    static public function create($value): self
    {
        if (is_numeric($value)) {
            return new Count($value);
        } elseif (is_array($value)) {
            return new Count(count($value));
        } elseif (is_string($value)) {
            return new Count(mb_strlen($value));
        }

        return new Count(0);
    }

    public function isOverSelf(Count $maxCount): bool
    {
        return $this->count > $maxCount->count;
    }
}
