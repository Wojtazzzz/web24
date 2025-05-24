<?php

declare(strict_types=1);

namespace App\Modules\Companies\Domain\Repositories;

use App\Modules\Companies\Domain\Models\Company;
use Illuminate\Support\Collection;

interface CompanyRepositoryInterface
{
    public function getCompanies(): Collection;

    public function getCompanyById(int $companyId): Company;

    /**
     * @param array{
     *     name: string,
     *     nip: string,
     *     address: string,
     *     city: string,
     *     postcode: string,
     * } $attributes
     */
    public function createCompany(array $attributes): bool|Company;

    /**
     * @param array{
     *     name: string,
     *     nip: string,
     *     address: string,
     *     city: string,
     *     postcode: string,
     * } $attributes
     */
    public function updateCompany(int $companyId, array $attributes): bool|Company;

    public function deleteCompany(int $companyId): bool;
}
