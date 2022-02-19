<?php

declare(strict_types=1);

namespace Tests\Unit\packages\Domain\Category;

use DevRecord\Domain\Category\Category;
use DevRecord\Domain\Category\CategoryInfo;
use DevRecord\Domain\Common\Id;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function test_to_dto(): void
    {
        $dto    = (new Category(new Id('test-id'), new CategoryInfo('テスト', 'test')))->toDto();
        $expect = ['id' => 'test-id', 'name' => 'テスト', 'slug' => 'test'];

        $this->assertEquals($expect, $dto->toColumns());
    }
}
