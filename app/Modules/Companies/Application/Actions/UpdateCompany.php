<?php

declare(strict_types=1);

namespace App\Modules\Companies\Application\Actions;

use App\Modules\Companies\Application\Dtos\UpdateCompanyDto;
use App\Modules\Companies\Domain\Models\Company;
use App\Modules\Companies\Domain\Repositories\CompanyRepositoryInterface;

final readonly class UpdateCompany
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepository,
    ) {}

    public function dispatch(UpdateCompanyDto $data): Company
    {
        return $this->companyRepository->updateCompany(
            companyId: $data->companyId,
            attributes: $data->getAttributes(),
        );
    }
}