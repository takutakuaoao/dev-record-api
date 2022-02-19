<?php

declare(strict_types=1);

namespace DevRecord\Application\Category\Find;

use DevRecord\Domain\Category\InterfaceCategoryRepository;

final class CategoryFindUseCase
{
    public function __construct(
        private InterfaceCategoryRepository $categoryRepository,
    ) {
    }

    public function execute(CategoryFindRequest $request): CategoryFindResponse
    {
        $id       = $request->makeId();
        $category = $this->categoryRepository->findId($id->toDto());

        return new CategoryFindResponse($category->toJson());
    }
}
