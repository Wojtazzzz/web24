<?php

declare(strict_types=1);

namespace App\Modules\Companies\Infrastructure\Repositories;

use App\Modules\Companies\Domain\Models\Company;
use App\Modules\Companies\Domain\Repositories\CompanyRepositoryInterface;
use App\Shared\Repositories\EloquentRepository;
use Illuminate\Support\Collection;

final class EloquentCompanyRepository extends EloquentRepository implements CompanyRepositoryInterface
{
    public function model(): string
    {
        return Company::class;
    }

    /**
     * @return Collection<int, Company>
     */
    public function getCompanies(): Collection
    {
        return $this->getBuilder()
            ->with($this->getRelations())
            ->orderByDesc('id')
            ->get($this->getColumns());
    }

    public function getCompanyById(int $companyId): Company
    {
        return $this->find(
            id: $companyId,
        );
    }

    public function createCompany(array $attributes): bool|Company
    {
        return $this->create(
            fields: $attributes,
        );
    }

    public function updateCompany(int $companyId, array $attributes): bool|Company
    {
        return $this->update(
            id: $companyId,
            fields: $attributes,
        );
    }

    public function deleteCompany(int $companyId): bool
    {
        return (bool) $this->delete(
            id: $companyId
        );
    }
}
