<?php

namespace App\Providers;

use App\Repositories\CharacterPersentageRepository;
use App\Repositories\CityRepository;
use App\Repositories\Contracts\CharacterPersentageRepositoryInterface;
use App\Repositories\Contracts\CityRepositoryInterface;
use App\Repositories\Contracts\DepartmentRepositoryInterface;
use App\Repositories\Contracts\FileServiceRepositoryInterface;
use App\Repositories\Contracts\JobTitleRepositoryInterface;
use App\Repositories\Contracts\ReimbursementRepositoryInterface;
use App\Repositories\Contracts\UsersRepositoryInterface;
use App\Repositories\DepartmentRepository;
use App\Repositories\FileServiceRepository;
use App\Repositories\JobTitleRepository;
use App\Repositories\ReimbursementRepository;
use App\Repositories\UsersRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CharacterPersentageRepositoryInterface::class, CharacterPersentageRepository::class);
        $this->app->bind(DepartmentRepositoryInterface::class, DepartmentRepository::class);
        $this->app->bind(JobTitleRepositoryInterface::class, JobTitleRepository::class);
        $this->app->bind(UsersRepositoryInterface::class, UsersRepository::class);
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
        $this->app->bind(ReimbursementRepositoryInterface::class, ReimbursementRepository::class);
        $this->app->bind(FileServiceRepositoryInterface::class, FileServiceRepository::class);



    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
