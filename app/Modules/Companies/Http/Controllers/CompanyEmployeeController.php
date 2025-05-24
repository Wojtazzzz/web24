<?php

declare(strict_types=1);

namespace App\Modules\Companies\Http\Controllers;

use App\Modules\Companies\Application\Actions\CreateEmployee;
use App\Modules\Companies\Application\Actions\UpdateEmployee;
use App\Modules\Companies\Domain\Models\Company;
use App\Modules\Companies\Domain\Models\Employee;
use App\Modules\Companies\Domain\Repositories\EmployeeRepositoryInterface;
use App\Modules\Companies\Http\Requests\StoreEmployeeRequest;
use App\Modules\Companies\Http\Requests\UpdateEmployeeRequest;
use App\Modules\Companies\Http\Resources\EmployeeResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

final readonly class CompanyEmployeeController
{
    public function __construct(
        private EmployeeRepositoryInterface $employeeRepository,
    ) {}

    public function index(Company $company): JsonResource
    {
        $companies = $this->employeeRepository
            ->setColumns([
                'id',
                'company_id',
                'first_name',
                'last_name',
                'email',
                'phone',
            ])
            ->getCompanyEmployees(
                companyId: $company->getKey(),
            );

        return EmployeeResource::collection($companies);
    }

    public function show(Company $company, Employee $employee): JsonResource
    {
        abort_if($company->getKey() !== $employee->company_id, 404);

        $company = $this->employeeRepository
            ->setColumns([
                'id',
                'company_id',
                'first_name',
                'last_name',
                'email',
                'phone',
            ])
            ->getCompanyEmployeeById(
                companyId: $company->getKey(),
                employeeId: $employee->getKey(),
            );

        return new EmployeeResource($company);
    }

    public function store(StoreEmployeeRequest $request, Company $company, CreateEmployee $action): Response
    {
        $company = $action->dispatch($request->toDto());

        return new EmployeeResource($company)
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateEmployeeRequest $request, Company $company, Employee $employee, UpdateEmployee $action): JsonResource
    {
        abort_if($company->getKey() !== $employee->company_id, 404);

        $company = $action->dispatch($request->toDto());

        return new EmployeeResource($company);
    }

    public function destroy(Company $company, Employee $employee): JsonResponse
    {
        abort_if($company->getKey() !== $employee->company_id, 404);

        $employee->delete();

        return response()->json([], 204);
    }
}
