<?php

declare(strict_types=1);

namespace App\Modules\Companies\Application\Actions;

use App\Modules\Companies\Application\Dtos\CreateCompanyDto;
use App\Modules\Companies\Domain\Models\Company;
use App\Modules\Companies\Domain\Repositories\CompanyRepositoryInterface;

final readonly class CreateCompany
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepository,
    ) {}

    public function dispatch(CreateCompanyDto $data): Company
    {
        return $this->companyRepository->createCompany(
            attributes: $data->getAttributes(),
        );
    }
}