<?php

namespace App\Providers;

use App\Interfaces\FileSharingGroupInterface;
use App\repositories\FileSharingGroupRepository;
use Illuminate\Support\ServiceProvider;

class FileSharingGroupServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(FileSharingGroupInterface::class, FileSharingGroupRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
