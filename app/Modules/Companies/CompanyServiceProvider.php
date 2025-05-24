<?php

declare(strict_types=1);

namespace App\Modules\Companies;

use App\Modules\Companies\Domain\Repositories\CompanyRepositoryInterface;
use App\Modules\Companies\Domain\Repositories\EmployeeRepositoryInterface;
use App\Modules\Companies\Infrastructure\Repositories\EloquentCompanyRepository;
use App\Modules\Companies\Infrastructure\Repositories\EloquentEmployeeRepository;
use Illuminate\Support\ServiceProvider;

final class CompanyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerRepositories();
    }

    public function boot(): void
    {
        //
    }

    private function registerRepositories(): void
    {
        $this->app->bind(CompanyRepositoryInterface::class, EloquentCompanyRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EloquentEmployeeRepository::class);
    }
}
