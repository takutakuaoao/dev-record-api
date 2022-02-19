<?php

declare(strict_types=1);

namespace DevRecord\Infrastructure\Repository\Article;

use App\Models\Article;
use Illuminate\Support\Facades\DB;

final class ArticleDbRepository
{
    const TABLE_NAME       = 'articles';
    private const RELATION = 'category';

    public function all(): array
    {
        return Article::with(static::RELATION)
            ->orderBy(ArticleColumns::ID_COLUMN_NAME, 'asc')
            ->get()
            ->toArray();
    }

    public function fetchAllPublicType(): array
    {
        return Article::with(static::RELATION)
            ->where(ArticleColumns::publicType())
            ->orderBy(ArticleColumns::ID_COLUMN_NAME, 'desc')
            ->get()
            ->toArray();
    }

    public function find(string $id): array
    {
        return Article::with(static::RELATION)
            ->where([ArticleColumns::ID_COLUMN_NAME => $id])
            ->first()
            ->toArray();
    }

    public function store(ArticleColumns $articleColumns): void
    {
        DB::table(static::TABLE_NAME)->insert($articleColumns->allColumns());
    }

    public function update(ArticleColumns $articleColumns): void
    {
        DB::table(static::TABLE_NAME)
            ->where($articleColumns->idColumn())
            ->update($articleColumns->updatingColumns());
    }

    public function findCategorySlugAndArticleSlug(string $categorySlug, string $articleSlug): ?array
    {
        $result = Article::with(static::RELATION)
            ->where(ArticleColumns::SLUG_COLUMN_NAME, '=', $articleSlug)
            ->whereHas('category', function ($query) use ($categorySlug) {
                $query->where('slug', '=', $categorySlug);
            })
            ->first();

        return $result?->toArray();
    }
}
