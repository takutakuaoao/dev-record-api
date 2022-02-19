<?php

declare(strict_types=1);

namespace Tests\Unit\packages\Infrastructure\Repository\Article;

use Carbon\Carbon;
use DevRecord\Infrastructure\Repository\Article\ArticleColumns;
use PHPUnit\Framework\TestCase;

class ArticleColumnsTest extends TestCase
{
    public function test_記事の情報をカラムと共に返す(): void
    {
        $articleColumns = new ArticleColumns(
            $id = 'test',
            $type = 1,
            $categoryId = 'categoryId',
            $title = 'title',
            $content = '# content',
            $slug = 'slug',
            $mainImgUrl = null,
            null,
            null,
        );

        $actual = $articleColumns->basicColumns();
        $expect = [
            ArticleColumns::ID_COLUMN_NAME          => $id,
            ArticleColumns::TYPE_COLUMN_NAME        => $type,
            ArticleColumns::CATEGORY_ID_COLUMN_NAME => $categoryId,
            ArticleColumns::TITLE_COLUMN_NAME       => $title,
            ArticleColumns::CONTENT_COLUMN_NAME     => $content,
            ArticleColumns::SLUG_COLUMN_NAME        => $slug,
            ArticleColumns::MAIN_IMG_COLUMN_NAME    => $mainImgUrl,
        ];

        $this->assertEquals($expect, $actual);
    }

    public function test_日付情報付きのカラム情報を返す(): void
    {
        $articleColumns = new ArticleColumns(
            $id = 'test',
            $type = 1,
            $categoryId = 'categoryId',
            $title = 'title',
            $content = '# content',
            $slug = 'slug',
            $mainImgUrl = null,
            Carbon::createFromTimeString($created_at = '2022/02/01 00:00:00'),
            $updated_at = null,
        );

        $actual = $articleColumns->allColumns();
        $expect = [
            ArticleColumns::ID_COLUMN_NAME          => $id,
            ArticleColumns::TYPE_COLUMN_NAME        => $type,
            ArticleColumns::CATEGORY_ID_COLUMN_NAME => $categoryId,
            ArticleColumns::TITLE_COLUMN_NAME       => $title,
            ArticleColumns::CONTENT_COLUMN_NAME     => $content,
            ArticleColumns::SLUG_COLUMN_NAME        => $slug,
            ArticleColumns::MAIN_IMG_COLUMN_NAME    => $mainImgUrl,
            ArticleColumns::CREATED_COLUMN_NAME     => $created_at,
            ArticleColumns::UPDATED_COLUMN_NAME     => $updated_at,
        ];

        $this->assertEquals($expect, $actual);
    }

    public function test_更新用のカラム情報を返す(): void
    {
        $articleColumns = new ArticleColumns(
            'id',
            $type = 1,
            $categoryId = 'category-id',
            $title = 'title',
            $content = '# content',
            $slug = 'slug',
            $mainImgUrl = null,
            Carbon::now(),
            Carbon::createFromTimeString($updatedAt = '2022/02/02 00:00:00'),
        );

        $expect = [
            ArticleColumns::TYPE_COLUMN_NAME        => $type,
            ArticleColumns::CATEGORY_ID_COLUMN_NAME => $categoryId,
            ArticleColumns::TITLE_COLUMN_NAME       => $title,
            ArticleColumns::CONTENT_COLUMN_NAME     => $content,
            ArticleColumns::SLUG_COLUMN_NAME        => $slug,
            ArticleColumns::MAIN_IMG_COLUMN_NAME    => $mainImgUrl,
            ArticleColumns::UPDATED_COLUMN_NAME     => $updatedAt,
        ];

        $this->assertEquals($expect, $articleColumns->updatingColumns());
    }
}
