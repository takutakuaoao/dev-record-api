<?php

declare(strict_types=1);

namespace DevRecord\Application\Category\Store;

final class CategoryStoreResponse
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
