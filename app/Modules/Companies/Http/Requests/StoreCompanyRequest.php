<?php

declare(strict_types=1);

namespace App\Modules\Companies\Http\Requests;

use App\Modules\Companies\Application\Dtos\CreateCompanyDto;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read ?string $name
 * @property-read ?string $nip
 * @property-read ?string $address
 * @property-read ?string $city
 * @property-read ?string $postcode
 */
final class StoreCompanyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:128',
            ],
            'nip' => [
                'required',
                'string',
                'regex:/^\d{10}$/',
            ],
            'address' => [
                'required',
                'string',
            ],
            'city' => [
                'required',
                'string',
            ],
            'postcode' => [
                'required',
                'string',
                'regex:/^\d{2}-\d{3}$/',
            ],
        ];
    }

    public function toDto(): CreateCompanyDto
    {
        return new CreateCompanyDto(
            name: $this->safe()->string('name')->value(),
            nip: $this->safe()->string('nip')->value(),
            address: $this->safe()->string('address')->value(),
            city: $this->safe()->string('city')->value(),
            postcode: $this->safe()->string('postcode')->value(),
        );
    }
}
