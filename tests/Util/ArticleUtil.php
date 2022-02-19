<?php

declare(strict_types=1);

namespace Tests\Util;

use Illuminate\Support\Facades\DB;

final class ArticleUtil
{
    public static function createRecord(
        string $id,
        int $type,
        ?string $content,
        ?string $slug,
        ?string $categoryId,
        ?string $mainImgUrl,
        ?string $createdAt,
        ?string $updatedAt,
    ): void {
        DB::table('articles')->insert([
            'id'           => $id,
            'content'      => $content,
            'slug'         => $slug,
            'category_id'  => $categoryId,
            'type'         => $type,
            'main_img_url' => $mainImgUrl,
            'created_at'   => $createdAt,
            'updated_at'   => $updatedAt,
        ]);
    }
}
