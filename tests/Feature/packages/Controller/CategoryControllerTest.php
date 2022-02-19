<?php

declare(strict_types=1);

namespace Tests\Feature\packages\Controller;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    public function test_index(): void
    {
        $newData = [
            ['id' => 'test-1', 'name' => 'PHP', 'slug' => 'php'],
            ['id' => 'test-2', 'name' => 'Perl', 'slug' => 'perl'],
        ];
        DB::table('categories')->insert($newData);

        $response = $this->get(route('category.index'));
        $items    = $response['data']['items'];

        $this->assertTrue($response['result']);
        $this->assertEquals($newData[0]['id'], $items[0]['id']);
        $this->assertEquals($newData[1]['id'], $items[1]['id']);
        $this->assertEquals(2, count($items));
    }

    public function test_store(): void
    {
        $response = $this->post(route('category.store'), ['name' => 'テスト', 'slug' => 'test']);

        $this->assertTrue($response['result']);
        $this->assertTrue($response['data']['isSuccess']);
    }

    public function test_edit(): void
    {
        $newData = $this->makeTestData();

        $response = $this->put(route('category.edit'), [
            'id'   => $newData['id'],
            'name' => 'edit-name',
            'slug' => 'edit-slug',
        ]);

        $this->assertTrue($response['result']);
        $this->assertTrue($response['data']['isSuccess']);
    }

    public function test_delete(): void
    {
        $newData = $this->makeTestData();

        $response = $this->delete(route('category.delete'), [
            'id' => $newData['id'],
        ]);

        $this->assertTrue($response['result']);
        $this->assertTrue($response['data']['isSuccess']);
    }

    public function test_find(): void
    {
        $newData = $this->makeTestData();

        $response = $this->get(route('category.find', ['id' => $newData['id']]));

        $this->assertTrue($response['result']);
        $this->assertEquals($newData, $response['data']['item']);
    }

    private function makeTestData(): array
    {
        $newData = ['id' => 'test', 'name' => 'test', 'slug' => 'test'];
        DB::table('categories')->insert($newData);

        return $newData;
    }
}
