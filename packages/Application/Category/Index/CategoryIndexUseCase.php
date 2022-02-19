<?php

declare(strict_types=1);

namespace DevRecord\Application\Category\Index;

use DevRecord\Domain\Category\Category;
use DevRecord\Domain\Category\InterfaceCategoryRepository;

final class CategoryIndexUseCase
{
    public function __construct(
        private InterfaceCategoryRepository $categoryRepository
    ) {
    }

    public function execute(): CategoryIndexResponse
    {
        $categories     = $this->categoryRepository->fetchAll();
        $categoriesJson = array_map(fn (Category $category) => $category->toJson(), $categories);

        return new CategoryIndexResponse($categoriesJson);
    }
}
