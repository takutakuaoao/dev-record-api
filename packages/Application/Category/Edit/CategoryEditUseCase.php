<?php

declare(strict_types=1);

namespace DevRecord\Application\Category\Edit;

use DevRecord\Domain\Category\InterfaceCategoryRepository;
use DevRecord\Domain\Common\Id;
use Illuminate\Support\Facades\DB;
use RuntimeException;

final class CategoryEditUseCase
{
    public function __construct(
        private InterfaceCategoryRepository $categoryRepository,
    ) {
    }

    public function execute(CategoryEditRequest $request): CategoryEditResponse
    {
        $editId = $request->toId();

        if (is_null($category = $this->categoryRepository->findId($editId->toDto()))) {
            throw new RuntimeException('Not found edit category.');
        }

        $updateCategory = $category->update($request->toCategoryInfo());
        $this->categoryRepository->update($updateCategory->toDto());

        return new CategoryEditResponse(true);
    }
}
