<?php

declare(strict_types=1);

namespace App\Modules\Companies\Domain\Repositories;

use App\Modules\Companies\Domain\Models\Employee;
use Illuminate\Support\Collection;

interface EmployeeRepositoryInterface
{
    public function getCompanyEmployees(int $companyId): Collection;

    public function getCompanyEmployeeById(int $companyId, int $employeeId): Employee;

    /**
     * @param array{
     *     company_id: int,
     *     first_name: string,
     *     last_name: string,
     *     email: string,
     *     phone: ?string,
     * } $attributes
     */
    public function createEmployee(array $attributes): bool|Employee;

    /**
     * @param array{
     *     first_name: string,
     *     last_name: string,
     *     email: string,
     *     phone: ?string,
     * } $attributes
     */
    public function updateEmployee(int $employeeId, array $attributes): bool|Employee;

    public function deleteEmployee(int $employeeId): bool;
}