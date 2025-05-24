<?php

declare(strict_types=1);

namespace App\Modules\Companies\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read int $id
 * @property-read int $company_id
 * @property-read string $first_name
 * @property-read string $last_name
 * @property-read string $email
 * @property-read ?string $phone
 */
final class EmployeeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'company' => [
                'id' => $this->company_id,
            ],
        ];
    }
}