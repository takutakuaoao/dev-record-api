<?php

declare(strict_types=1);

namespace DevRecord\Application\Category\Delete;

use DevRecord\Domain\Category\InterfaceCategoryRepository;

final class CategoryDeleteUseCase
{
    public function __construct(
        private InterfaceCategoryRepository $categoryRepository,
    ) {
    }

    public function execute(CategoryDeleteRequest $request): CategoryDeleteResponse
    {
        $deleteId = $request->makeDeleteId();

        $this->categoryRepository->delete($deleteId->toDto());

        return new CategoryDeleteResponse(true);
    }
}
