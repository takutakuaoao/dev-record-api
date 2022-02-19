<?php

declare(strict_types=1);

namespace DevRecord\Application\Category\Delete;

final class CategoryDeleteResponse
{
    public function __construct(
        private bool $isSuccess,
    ) {
    }

    public function toArray(): array
    {
        return [
            'isSuccess' => $this->isSuccess,
        ];
    }
}
