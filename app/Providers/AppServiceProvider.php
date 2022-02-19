<?php

namespace App\Providers;

use DevRecord\Domain\Category\InterfaceCategoryRepository;
use DevRecord\Infrastructure\Repository\Category\CategoryRepository;
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
