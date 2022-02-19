<?php

declare(strict_types=1);

namespace Tests\Feature\packages\Application\Category;

use DevRecord\Application\Category\Store\CategoryStoreRequest;
use DevRecord\Application\Category\Store\CategoryStoreUseCase;
use DevRecord\Infrastructure\Repository\Category\CategoryRepository;
use Tests\TestCase;

class CategoryStoreTest extends TestCase
{
    public function test_store(): void
    {
        $useCase = new CategoryStoreUseCase(new CategoryRepository);
        $request = new CategoryStoreRequest('テスト', 'test');

        $response = $useCase->execute($request);

        $this->assertTrue($response->toArray()['isSuccess']);
    }
}
