<?php

namespace App\Providers;

use Domain\Post\PostRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Post\DoctrinePostRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PostRepositoryInterface::class, DoctrinePostRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
