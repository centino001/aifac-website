<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use App\Repositories\Eloquent\ProjectRepository;
use App\Repositories\Contracts\NewsRepositoryInterface;
use App\Repositories\Eloquent\NewsRepository;
use App\Repositories\Contracts\PersonRepositoryInterface;
use App\Repositories\Eloquent\PersonRepository;
use App\Repositories\Contracts\DonationRepositoryInterface;
use App\Repositories\Eloquent\DonationRepository;
use App\Repositories\Contracts\VolunteerRepositoryInterface;
use App\Repositories\Eloquent\VolunteerRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(NewsRepositoryInterface::class, NewsRepository::class);
        $this->app->bind(PersonRepositoryInterface::class, PersonRepository::class);
        $this->app->bind(DonationRepositoryInterface::class, DonationRepository::class);
        $this->app->bind(VolunteerRepositoryInterface::class, VolunteerRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
} 