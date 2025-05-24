<?php

declare(strict_types=1);

namespace App\Modules\Companies\Http\Controllers;

use App\Modules\Companies\Application\Actions\CreateCompany;
use App\Modules\Companies\Application\Actions\UpdateCompany;
use App\Modules\Companies\Domain\Models\Company;
use App\Modules\Companies\Domain\Repositories\CompanyRepositoryInterface;
use App\Modules\Companies\Http\Requests\StoreCompanyRequest;
use App\Modules\Companies\Http\Requests\UpdateCompanyRequest;
use App\Modules\Companies\Http\Resources\CompanyResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

final readonly class CompanyController
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepository,
    ) {}

    public function index(): JsonResource
    {
        $companies = $this->companyRepository
            ->setColumns([
                'id',
                'name',
                'nip',
                'address',
                'city',
                'postcode',
            ])
            ->getCompanies();

        return CompanyResource::collection($companies);
    }

    public function show(Company $company): JsonResource
    {
        $company = $this->companyRepository
            ->setColumns([
                'id',
                'name',
                'nip',
                'address',
                'city',
                'postcode',
            ])
            ->getCompanyById(
                companyId: $company->getKey(),
            );

        return new CompanyResource($company);
    }

    public function store(StoreCompanyRequest $request, CreateCompany $action): Response
    {
        $company = $action->dispatch($request->toDto());

        return new CompanyResource($company)
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateCompanyRequest $request, Company $company, UpdateCompany $action): JsonResource
    {
        $company = $action->dispatch($request->toDto());

        return new CompanyResource($company);
    }

    public function destroy(Company $company): JsonResponse
    {
        $company->delete();

        return response()->json([], 204);
    }
}
