<?php

declare(strict_types=1);

namespace App\Models;

use DevRecord\Infrastructure\Repository\Category\CategoryRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $tableName = CategoryRepository::TABLE_NAME;
    public $incrementing = false;
    protected $keyType   = 'string';
}
