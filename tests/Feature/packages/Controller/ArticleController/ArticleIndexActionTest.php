<?php

declare(strict_types=1);

namespace Tests\Feature\packages\Controller\ArticleController;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Tests\Util\ArticleUtil;

class ArticleIndexActionTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        DB::table('categories')->insert(['id' => 'category-id', 'name' => 'test', 'slug' => 'test', ]);
        ArticleUtil::createRecord('test-1', 1, '# content', 'slug-1', 'category-id', null, '2022/01/01 00:00:00', null, );
        ArticleUtil::createRecord('test-2', 2, '# content2', 'slug-2', 'category-id', null, '2022/01/01 00:00:00', null, );
    }

    public function test_記事一覧表示用のレスポンスを返す(): void
    {
        $response = $this->get(route('article.index'));

        $this->assertTrue($response['result']);
        $this->assertEquals(2, $response['data']['allCount']);

        $this->assertEquals('test-1', $response['data']['list'][0]['id']);
        $this->assertEquals('test-2', $response['data']['list'][1]['id']);

        $this->assertEquals('category-id', $response['data']['list'][0]['category']['id']);
        $this->assertEquals('category-id', $response['data']['list'][1]['category']['id']);
    }

    public function test_IDで指定した記事のレスポンスを返す(): void
    {
        $response = $this->get(route('article.show', ['id' => 'test-1']));

        $this->assertEquals('test-1', $response['data']['item']['id']);
        $this->assertEquals('category-id', $response['data']['item']['category']['id']);
    }

    public function test_公開されている記事の一覧のレスポンスを返す(): void
    {
        $response = $this->get(route('public.article.index'));

        $this->assertSame(1, $response['data']['allCount']);
        $this->assertSame('test-1', $response['data']['list'][0]['id']);
    }

    public function test_公開記事から指定したカテゴリスラッグと記事スラッグと一致する記事を一件取得する(): void
    {
        $response = $this->get(route('public.article.show', ['categorySlug' => 'test', 'articleSlug' => 'slug-1']));

        $this->assertSame('test-1', $response['data']['item']['id']);
    }
}
