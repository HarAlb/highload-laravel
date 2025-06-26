<?php

namespace App\Providers;

use Domain\Media\MediaRepositoryInterface;
use Domain\Post\PostRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Media\DoctrineMediaRepository;
use Infrastructure\Post\DoctrinePostRepository;
use Shared\Media\Contract\MediaCompressorInterface;
use Shared\Media\Service\MediaCompressor;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PostRepositoryInterface::class, DoctrinePostRepository::class);

        $this->app->bind(MediaRepositoryInterface::class, DoctrineMediaRepository::class);

        $this->app->bind(MediaCompressorInterface::class, MediaCompressor::class);

        $this->app->when(MediaCompressor::class)
            ->needs('$strategies')
            ->give(function ($app) {
                return [
                    $app->make(\Shared\Media\Service\Strategy\ImageCompressor::class),
                    $app->make(\Shared\Media\Service\Strategy\VideoCompressor::class),
                ];
            });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
