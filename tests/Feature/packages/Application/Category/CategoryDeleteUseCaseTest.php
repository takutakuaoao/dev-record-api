<?php

namespace Tests\Feature\packages\Application\Category;

use DevRecord\Application\Category\Delete\CategoryDeleteRequest;
use DevRecord\Application\Category\Delete\CategoryDeleteUseCase;
use DevRecord\Infrastructure\Repository\Category\CategoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CategoryDeleteUseCaseTest extends TestCase
{
    public function test_delete(): void
    {
        $newData = ['id' => 'test1', 'name' => 'yyy', 'slug' => 'zzz'];
        DB::table('categories')->insert($newData);

        $request = new CategoryDeleteRequest('test1');
        $useCase = new CategoryDeleteUseCase(new CategoryRepository);

        $response = $useCase->execute($request);

        $this->assertDatabaseMissing('categories', ['id' => $newData['id']]);
        $this->assertTrue($response->toArray()['isSuccess']);
    }
}
