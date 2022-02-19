<?php

declare(strict_types=1);

namespace DevRecord\Domain\Category;

use DevRecord\Domain\Common\IdDto;

final class CategoryDto
{
    public function __construct(
        private IdDto $id,
        private CategoryInfoDto $info,
    ) {
    }

    public function toColumns(): array
    {
        return $this->id->addIdColumn($this->info->toColumns());
    }

    public function toWhereId():array
    {
        return $this->id->toWhere();
    }

    public function toUpdateData(): array
    {
        return $this->info->toColumns();
    }
}
