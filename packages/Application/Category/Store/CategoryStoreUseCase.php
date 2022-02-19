<?php

declare(strict_types=1);

namespace DevRecord\Application\Category\Store;

use DevRecord\Domain\Category\Category;
use DevRecord\Domain\Category\InterfaceCategoryRepository;

final class CategoryStoreUseCase
{
    public function __construct(
        private InterfaceCategoryRepository $categoryRepository,
    ) {
    }

    public function execute(CategoryStoreRequest $request): CategoryStoreResponse
    {
        $category = $request->makeCategory();
        $this->categoryRepository->store($category->toDto());

        return new CategoryStoreResponse(true);
    }
}
