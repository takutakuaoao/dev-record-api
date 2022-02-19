<?php

declare(strict_types=1);

namespace Tests\Feature\packages\Controller\ArticleController;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ArticleUpdateActionTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        DB::table('categories')->insert([
            'id'   => 'category-id',
            'name' => 'test',
            'slug' => 'test',
        ]);
    }

    public function test_記事の更新(): void
    {
        DB::table('categories')->insert([
            'id'   => $editCategoryId = 'category-id-2',
            'name' => 'edit category name',
            'slug' => 'edit-slug',
        ]);
        DB::table($tableName = 'articles')->insert([
            $idColumnName = 'id' => $id = 'article-id',
            'category_id'        => 'category-id',
            'title'              => 'title',
            'content'            => 'content',
            'slug'               => 'slug',
            'main_img_url'       => 'https://dev.com',
            'type'               => 1,
            'created_at'         => $createdAt = '2022/02/01 00:00:00',
            'updated_at'         => null,
        ]);

        $response = $this->put(route('article.update'), [
            'id'         => $id,
            'categoryId' => $editCategoryId,
            'title'      => $editTitle = 'edit title',
            'content'    => $editContent = '# edit content',
            'slug'       => $editSlug = 'edit-slug',
            'mainImgUrl' => '',
            'type'       => $updatedType = 2,
        ]);

        $updatedArticle = DB::table($tableName)->where($idColumnName, $id)->first();

        $this->assertSame($updatedArticle->category_id, $editCategoryId);
        $this->assertSame($updatedArticle->title, $editTitle);
        $this->assertSame($updatedArticle->content, $editContent);
        $this->assertSame($updatedArticle->slug, $editSlug);
        $this->assertNull($updatedArticle->main_img_url);
        $this->assertSame($updatedArticle->type, $updatedType);
        $this->assertSame($updatedArticle->created_at, $createdAt);
        $this->assertTrue(!is_null($updatedArticle->updated_at));

        $this->assertTrue($response['result']);
        $this->assertSame($response['data']['id'], $id);
    }
}
