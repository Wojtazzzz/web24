<?php

declare(strict_types=1);

namespace App\Modules\Companies\Application\Actions;

use App\Modules\Companies\Application\Dtos\UpdateEmployeeDto;
use App\Modules\Companies\Domain\Models\Employee;
use App\Modules\Companies\Domain\Repositories\EmployeeRepositoryInterface;

final readonly class UpdateEmployee
{
    public function __construct(
        private EmployeeRepositoryInterface $employeeRepository,
    ) {}

    public function dispatch(UpdateEmployeeDto $data): Employee
    {
        return $this->employeeRepository->updateEmployee(
            employeeId: $data->employeeId,
            attributes: $data->getAttributes(),
        );
    }
}