<?php

declare(strict_types=1);

namespace DevRecord\Infrastructure\Repository\Article;

use Carbon\Carbon;

final class ArticleColumns
{
    const ID_COLUMN_NAME          = 'id';
    const TYPE_COLUMN_NAME        = 'type';
    const CATEGORY_ID_COLUMN_NAME = 'category_id';
    const TITLE_COLUMN_NAME       = 'title';
    const CONTENT_COLUMN_NAME     = 'content';
    const SLUG_COLUMN_NAME        = 'slug';
    const MAIN_IMG_COLUMN_NAME    = 'main_img_url';
    const CREATED_COLUMN_NAME     = 'created_at';
    const UPDATED_COLUMN_NAME     = 'updated_at';

    const DATE_FORMAT = 'Y/m/d H:i:s';

    const PUBLIC_TYPE = 1;

    public function __construct(
        private string $id,
        private int $type,
        private ?string $categoryId,
        private ?string $title,
        private ?string $content,
        private ?string $slug,
        private ?string $mainImgUrl,
        private ?Carbon $created_at,
        private ?Carbon $updated_at,
    ) {
    }

    public static function publicType(): array
    {
        return [
            static::TYPE_COLUMN_NAME => static::PUBLIC_TYPE,
        ];
    }

    public function idColumn(): array
    {
        return [static::ID_COLUMN_NAME => $this->id];
    }

    public function basicColumns(): array
    {
        return $this->idColumn() + $this->articleInfoColumns();
    }

    public function allColumns(): array
    {
        return array_merge($this->basicColumns(), $this->createdAtColumn(), $this->updatedAtColumn());
    }

    public function updatingColumns(): array
    {
        return $this->articleInfoColumns() + $this->updatedAtColumn();
    }

    private function articleInfoColumns(): array
    {
        return [
            static::TYPE_COLUMN_NAME        => $this->type,
            static::CATEGORY_ID_COLUMN_NAME => $this->categoryId,
            static::TITLE_COLUMN_NAME       => $this->title,
            static::CONTENT_COLUMN_NAME     => $this->content,
            static::SLUG_COLUMN_NAME        => $this->slug,
            static::MAIN_IMG_COLUMN_NAME    => $this->mainImgUrl,
        ];
    }

    private function createdAtColumn(): array
    {
        return [
            static::CREATED_COLUMN_NAME => $this->created_at?->format(static::DATE_FORMAT),
        ];
    }

    private function updatedAtColumn(): array
    {
        return [
            static::UPDATED_COLUMN_NAME => $this->updated_at?->format(static::DATE_FORMAT),
        ];
    }
}
