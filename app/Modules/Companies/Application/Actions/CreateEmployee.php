<?php

declare(strict_types=1);

namespace App\Modules\Companies\Application\Actions;

use App\Modules\Companies\Application\Dtos\CreateEmployeeDto;
use App\Modules\Companies\Domain\Models\Employee;
use App\Modules\Companies\Domain\Repositories\EmployeeRepositoryInterface;

final readonly class CreateEmployee
{
    public function __construct(
        private EmployeeRepositoryInterface $employeeRepository,
    ) {}

    public function dispatch(CreateEmployeeDto $data): Employee
    {
        return $this->employeeRepository->createEmployee(
            attributes: $data->getAttributes(),
        );
    }
}
