<?php

namespace App\Providers;

use DevRecord\Domain\Category\InterfaceCategoryRepository;
use DevRecord\Infrastructure\Repository\Category\CategoryRepository;
use DevRecord\Infrastructure\Storage\LocalStorage;
use DevRecord\Infrastructure\Storage\S3Storage;
use DevRecord\Infrastructure\Storage\StorageInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(InterfaceCategoryRepository::class, CategoryRepository::class);

        if (App::isProduction()) {
            $this->app->bind(StorageInterface::class, S3Storage::class);
        } else {
            $this->app->bind(StorageInterface::class, LocalStorage::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if (App::environment('production')) {
            URL::forceScheme('https');
        }
    }
}
