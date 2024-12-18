<?php

namespace App\Providers;

use App\Repository\Person\PersonRepository;
use App\Repository\Person\PersonRepositoryInterface;
use App\Repository\Publication\PublicationRepository;
use App\Repository\Publication\PublicationRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(PersonRepositoryInterface::class, PersonRepository::class);
        $this->app->bind(PublicationRepositoryInterface::class, PublicationRepository::class);
    }
}
