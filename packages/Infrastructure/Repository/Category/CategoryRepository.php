<?php

declare(strict_types=1);

namespace DevRecord\Infrastructure\Repository\Category;

use DevRecord\Domain\Category\Category;
use DevRecord\Domain\Category\CategoryDto;
use DevRecord\Domain\Category\InterfaceCategoryRepository;
use DevRecord\Domain\Common\IdDto;
use Illuminate\Support\Facades\DB;

final class CategoryRepository implements InterfaceCategoryRepository
{
    const TABLE_NAME = 'categories';

    /**
     * @return Category[]
     */
    public function fetchAll(): array
    {
        $allCategories = DB::table(self::TABLE_NAME)->get()->toArray();

        return array_map(fn ($category) => Category::create($category->id, $category->name, $category->slug), $allCategories);
    }

    public function store(CategoryDto $dto): void
    {
        DB::table(self::TABLE_NAME)->insert($dto->toColumns());
    }

    public function findId(IdDto $dto): ?Category
    {
        $result = DB::table(self::TABLE_NAME)->where($dto->toWhere());

        if (!$result->exists()) {
            return null;
        }

        $category = $result->first();

        return Category::create($category->id, $category->name, $category->slug);
    }

    public function update(CategoryDto $dto): void
    {
        $query = DB::table(self::TABLE_NAME)->where($dto->toWhereId());
        $query->update($dto->toUpdateData());
    }

    public function delete(IdDto $dto): void
    {
        $sql = DB::table(self::TABLE_NAME)->where($dto->toWhere());
        $sql->delete();
    }
}
