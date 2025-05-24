<?php

declare(strict_types=1);

namespace App\Modules\Companies\Http\Requests;

use App\Modules\Companies\Application\Dtos\CreateEmployeeDto;
use App\Modules\Companies\Domain\Models\Company;
use App\Modules\Companies\Domain\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read Company $company
 * @property-read ?string $first_name
 * @property-read ?string $last_name
 * @property-read ?string $email
 * @property-read ?string $phone
 */
final class StoreEmployeeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => [
                'required',
                'string',
            ],
            'last_name' => [
                'required',
                'string',
            ],
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique(new Employee()->getTable(), 'email')
                    ->where('company_id', $this->company->getKey()),
            ],
            'phone' => [
                'nullable',
                'string',
                'regex:/^[0-9]{9}$/',
            ],
        ];
    }

    public function toDto(): CreateEmployeeDto
    {
        return new CreateEmployeeDto(
            companyId: $this->company->getKey(),
            firstName: $this->safe()->string('first_name')->value(),
            lastName: $this->safe()->string('last_name')->value(),
            email: $this->safe()->string('email')->value(),
            phone: '' !== $this->safe()->string('phone')->value() ? $this->safe()->string('phone')->value() : null,
        );
    }
}
