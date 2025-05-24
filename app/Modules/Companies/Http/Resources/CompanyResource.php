<?php

declare(strict_types=1);

namespace App\Modules\Companies\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read string $nip
 * @property-read string $address
 * @property-read string $city
 * @property-read string $postcode
 */
final class CompanyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'nip' => (string) $this->nip,
            'address' => $this->address,
            'city' => $this->city,
            'postcode' => $this->postcode,
        ];
    }
}
