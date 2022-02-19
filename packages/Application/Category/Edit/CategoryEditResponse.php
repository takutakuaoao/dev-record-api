<?php

declare(strict_types=1);

namespace DevRecord\Application\Category\Edit;

final class CategoryEditResponse
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
