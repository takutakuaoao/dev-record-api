<?php

declare(strict_types=1);

namespace App\Models;

use DevRecord\Infrastructure\Repository\Article\ArticleDbRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $tableName = ArticleDbRepository::TABLE_NAME;
    public $incrementing = false;
    protected $keyType   = 'string';

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
