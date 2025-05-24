<?php

declare(strict_types=1);

namespace App\Modules\Companies\Infrastructure\Repositories;

use App\Modules\Companies\Domain\Models\Employee;
use App\Modules\Companies\Domain\Repositories\EmployeeRepositoryInterface;
use App\Shared\Repositories\EloquentRepository;
use Illuminate\Database\Eloquent\Collection;

final class EloquentEmployeeRepository extends EloquentRepository implements EmployeeRepositoryInterface
{
    public function model(): string
    {
        return Employee::class;
    }

    /**
     * @return Collection<int, Employee>
     */
    public function getCompanyEmployees(int $companyId): Collection
    {
        return $this->getBuilder()
            ->with($this->getRelations())
            ->where('company_id', $companyId)
            ->orderByDesc('id')
            ->get($this->getColumns());
    }

    public function getCompanyEmployeeById(int $companyId, int $employeeId): Employee
    {
        return $this->findFirstWhere([
            'id' => $employeeId,
            'company_id' => $companyId,
        ]);
    }

    public function createEmployee(array $attributes): bool|Employee
    {
        return $this->create(
            fields: $attributes,
        );
    }

    public function updateEmployee(int $employeeId, array $attributes): bool|Employee
    {
        return $this->update(
            id: $employeeId,
            fields: $attributes,
        );
    }

    public function deleteEmployee(int $employeeId): bool
    {
        return (bool) $this->delete(
            id: $employeeId
        );
    }
}
