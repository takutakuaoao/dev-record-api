<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'health'], function() {
    Route::get('', function() {
        return [
            'health' => true,
        ];
    });
});

Route::group(['prefix' => 'categories'], function() {
    Route::get('', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/{id}', [CategoryController::class, 'find'])->name('category.find');
    Route::post('store', [CategoryController::class, 'store'])->name('category.store');
    Route::put('edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::delete('delete', [CategoryController::class, 'delete'])->name('category.delete');
});

Route::group(['prefix' => 'article'], function() {
    Route::get('', [ArticleController::class, 'index'])->name('article.index');
    Route::get('/{id}', [ArticleController::class, 'show'])->name('article.show');
    Route::post('store', [ArticleController::class, 'store'])->name('article.store');
    Route::put('update', [ArticleController::class, 'update'])->name('article.update');
});

Route::group(['prefix' => 'public'], function() {
    Route::group(['prefix' => 'article'], function() {
        Route::get('', [ArticleController::class, 'publicIndex'])->name('public.article.index');
        Route::get('/{categorySlug}/{articleSlug}', [ArticleController::class, 'publicShow'])->name('public.article.show');
    });
});
