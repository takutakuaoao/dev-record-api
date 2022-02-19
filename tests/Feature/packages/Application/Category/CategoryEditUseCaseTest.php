<?php

declare(strict_types=1);

namespace Tests\Feature\packages\Application\Category;

use DevRecord\Application\Category\Edit\CategoryEditRequest;
use DevRecord\Application\Category\Edit\CategoryEditUseCase;
use DevRecord\Infrastructure\Repository\Category\CategoryRepository;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CategoryEditUseCaseTest extends TestCase
{
    public function test_edit(): void
    {
        $newData = [
            'id'   => 'test',
            'name' => 'name',
            'slug' => 'slug',
        ];
        $updateData = [
            'id'   => $newData['id'],
            'name' => 'edit-name',
            'slug' => 'edit-slug',
        ];

        DB::table('categories')->insert($newData);
        $request = (new CategoryEditRequest($updateData['id'], $updateData['name'], $updateData['slug']));
        $useCase = (new CategoryEditUseCase(new CategoryRepository));

        $response = $useCase->execute($request);

        $this->assertEquals(['isSuccess' => true], $response->toArray());
        $this->assertDatabaseHas('categories', $updateData);
        $this->assertDatabaseMissing('categories', $newData);
    }
}
