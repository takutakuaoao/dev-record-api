<?php

declare(strict_types=1);

namespace Tests\Unit\packages\Infrastructure\Repository\Category;

use DevRecord\Domain\Category\Category;
use DevRecord\Domain\Category\CategoryDto;
use DevRecord\Domain\Category\CategoryInfoDto;
use DevRecord\Domain\Common\Id;
use DevRecord\Domain\Common\IdDto;
use DevRecord\Infrastructure\Repository\Category\CategoryRepository;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CategoryRepositoryTest extends TestCase
{
    private CategoryRepository $categoryRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->categoryRepository = new CategoryRepository();
    }

    public function test_index(): void
    {
        $inserts = [['id' => 'test1', 'name' => 'PHP', 'slug' => 'php'], ['id' => 'test2', 'name' => 'Perl', 'slug' => 'perl']];
        DB::table('categories')->insert($inserts);

        /** @var Category[] $allCategories */
        $allCategories = $this->categoryRepository->fetchAll();

        $this->assertEquals(2, count($allCategories));
        $this->assertTrue($allCategories[0]->isSame(new Id('test1')));
        $this->assertTrue($allCategories[1]->isSame(new Id('test2')));
    }

    public function test_store(): void
    {
        $id       = (new IdDto('test-id'));
        $info     = (new CategoryInfoDto('テスト', 'test'));
        $category = new CategoryDto($id, $info);

        $this->categoryRepository->store($category);

        $this->assertDatabaseHas('categories', ['id' => 'test-id', 'name' => 'テスト', 'slug' => 'test']);
    }

    public function test_find_id(): void
    {
        DB::table('categories')->insert(['id' => 'test', 'name' => 'xxx', 'slug' => 'xxx']);
        $id = new IdDto('test');

        $category = $this->categoryRepository->findId($id);
        $this->assertTrue($category->isSame(new Id('test')));
    }

    public function test_update(): void
    {
        $newData    = ['id' => 'test1', 'name' => 'yyy', 'slug' => 'zzz'];
        $updateData = ['id' => $newData['id'], 'name' => 'update-name', 'slug' => 'update-slug'];

        DB::table('categories')->insert($newData);
        $this->categoryRepository->update(new CategoryDto(new IdDto($updateData['id']), new CategoryInfoDto($updateData['name'], $updateData['slug'])));

        $this->assertDatabaseHas('categories', $updateData);
        $this->assertDatabaseMissing('categories', $newData);
    }

    public function test_delete(): void
    {
        $newData = ['id' => 'test1', 'name' => 'yyy', 'slug' => 'zzz'];
        DB::table('categories')->insert($newData);

        $this->categoryRepository->delete(new IdDto($newData['id']));

        $this->assertDatabaseMissing('categories', $newData);
    }
}
