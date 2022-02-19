<?php

declare(strict_types=1);

namespace DevRecord\Domain\Category;

use DevRecord\Domain\Common\IdDto;

interface InterfaceCategoryRepository
{
    /**
     * @return Category[]
     */
    public function fetchAll(): array;
    public function store(CategoryDto $dto): void;
    public function update(CategoryDto $dto): void;
    public function delete(IdDto $dto): void;
    public function findId(IdDto $dto): ?Category;
}
