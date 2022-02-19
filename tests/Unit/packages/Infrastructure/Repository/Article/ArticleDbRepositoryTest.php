<?php

declare(strict_types=1);

namespace Tests\Unit\packages\Infrastructure\Repository\Article;

use Carbon\Carbon;
use DevRecord\Infrastructure\Repository\Article\ArticleColumns;
use DevRecord\Infrastructure\Repository\Article\ArticleDbRepository;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Tests\Util\ArticleUtil;

class ArticleDbRepositoryTest extends TestCase
{
    public function test_全記事を取得する(): void
    {
        DB::table('categories')->insert(['id' => 'category-1', 'name' => 'test', 'slug' => 'test-slug']);
        ArticleUtil::createRecord('1', 1, 'test-1', 'slug-1', 'category-1', null, '2022/02/01 00:00:00', null);
        ArticleUtil::createRecord('2', 1, 'test-2', 'slug-2', 'category-1', null, '2022/02/01 00:00:00', null);

        $repository = new ArticleDbRepository;
        $allArticles = $repository->all();

        $this->assertEquals(2, count($allArticles));
        $this->assertEquals('1', $allArticles[0]['id']);
        $this->assertEquals('2', $allArticles[1]['id']);

        $this->assertEquals('category-1', $allArticles[0]['category']['id']);
        $this->assertEquals('category-1', $allArticles[1]['category']['id']);
    }

    public function test_新規登録後にDBにデータが登録されている(): void
    {
        $articleData = new ArticleColumns(
            'id',
            1,
            'category-id',
            'title',
            'content',
            'slug',
            'https://test.com',
            Carbon::now(),
            null,
        );
        $repository = new ArticleDbRepository;

        $repository->store($articleData);

        $this->assertDatabaseHas(ArticleDbRepository::TABLE_NAME, $articleData->allColumns());
    }

    public function test_更新後にDBが反映されている(): void
    {
        $created = now();
        DB::table(ArticleDbRepository::TABLE_NAME)->insert([
            ArticleColumns::ID_COLUMN_NAME          => $updatingArticleId = 'article-id',
            ArticleColumns::TYPE_COLUMN_NAME        => 1,
            ArticleColumns::CATEGORY_ID_COLUMN_NAME => 'category-id',
            ArticleColumns::TITLE_COLUMN_NAME       => 'title',
            ArticleColumns::CONTENT_COLUMN_NAME     => 'content',
            ArticleColumns::SLUG_COLUMN_NAME        => 'slug',
            ArticleColumns::MAIN_IMG_COLUMN_NAME    => 'https://example.com',
            ArticleColumns::CREATED_COLUMN_NAME     => $created->format('Y/m/d H:i:s'),
            ArticleColumns::UPDATED_COLUMN_NAME     => null,
        ]);
        $repository = new ArticleDbRepository;

        $updateArticle = new ArticleColumns(
            $updatingArticleId,
            2,
            null,
            null,
            null,
            null,
            null,
            $created,
            now(),
        );

        $repository->update($updateArticle);

        $this->assertDatabaseHas(ArticleDbRepository::TABLE_NAME, $updateArticle->allColumns());
    }

    public function test_カテゴリスラッグと記事スラッグが一致したデータを返す(): void
    {
        DB::table('categories')->insert(['id' => 'category-1', 'name' => 'test', 'slug' => $categorySlug = 'category-slug']);
        DB::table(ArticleDbRepository::TABLE_NAME)->insert([
            ArticleColumns::ID_COLUMN_NAME          => 'article-1',
            ArticleColumns::TYPE_COLUMN_NAME        => 1,
            ArticleColumns::CATEGORY_ID_COLUMN_NAME => 'category-1',
            ArticleColumns::TITLE_COLUMN_NAME       => 'title',
            ArticleColumns::CONTENT_COLUMN_NAME     => 'content',
            ArticleColumns::SLUG_COLUMN_NAME        => $articleSlug = 'article-slug',
            ArticleColumns::MAIN_IMG_COLUMN_NAME    => null,
            ArticleColumns::CREATED_COLUMN_NAME     => '2022/02/02 00:00:00',
            ArticleColumns::UPDATED_COLUMN_NAME     => null,
        ]);

        $repository = new ArticleDbRepository;

        $result = $repository->findCategorySlugAndArticleSlug($categorySlug, $articleSlug);
        $this->assertSame('article-1', $result['id']);
        $this->assertSame('category-1', $result['category']['id']);

        $notFoundCategory = $repository->findCategorySlugAndArticleSlug('category-slug-2', $articleSlug);
        $this->assertNull($notFoundCategory);

        $notFoundArticle = $repository->findCategorySlugAndArticleSlug($categorySlug, 'article-2');
        $this->assertNull($notFoundArticle);
    }
}
