<?php

declare(strict_types=1);

namespace DevRecord\Domain\Common;

final class IdDto
{
    public function __construct(
        private string $id,
    ) {
    }

    public function toWhere(): array
    {
        return [
            'id' => $this->id,
        ];
    }

    public function addIdColumn(array $columns): array
    {
        $columns['id'] = $this->id;

        return $columns;
    }
}
