<?php

declare(strict_types=1);

namespace Tests\Feature\packages\Application\Category;

use DevRecord\Application\Category\Find\CategoryFindRequest;
use DevRecord\Application\Category\Find\CategoryFindUseCase;
use DevRecord\Infrastructure\Repository\Category\CategoryRepository;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CategoryFindUseCaseTest extends TestCase
{
    public function test_get_item(): void
    {
        $newData = ['id' => 'test-1', 'name' => 'TEST', 'slug' => 'test'];
        DB::table('categories')->insert($newData);

        $request = new CategoryFindRequest($newData['id']);
        $useCase = new CategoryFindUseCase(new CategoryRepository);

        $response = $useCase->execute($request);

        $this->assertEquals(['item' => $newData], $response->toArray());
    }
}
