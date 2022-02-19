<?php

declare(strict_types=1);

namespace Tests\Feature\packages\Application\Category;

use DevRecord\Application\Category\Index\CategoryIndexUseCase;
use DevRecord\Infrastructure\Repository\Category\CategoryRepository;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CategoryIndexUseCaseTest extends TestCase
{
    public function test_index(): void
    {
        $newData = [
            ['id' => 'test-1', 'name' => 'PHP', 'slug' => 'php'],
            ['id' => 'test-2', 'name' => 'Perl', 'slug' => 'perl'],
        ];
        DB::table('categories')->insert($newData);

        $useCase  = (new CategoryIndexUseCase(new CategoryRepository));
        $response = $useCase->execute();

        $this->assertEquals('test-1', $response->toArray()['items'][0]['id']);
        $this->assertEquals('test-2', $response->toArray()['items'][1]['id']);
    }
}
