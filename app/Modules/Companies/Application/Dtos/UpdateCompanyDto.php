<?php

declare(strict_types=1);

namespace App\Modules\Companies\Application\Dtos;

final readonly class UpdateCompanyDto
{
    public function __construct(
        public int $companyId,
        public string $name,
        public string $nip,
        public string $address,
        public string $city,
        public string $postcode,
    ) {}

    /**
     * @return array{
     *     name: string,
     *     nip: string,
     *     address: string,
     *     city: string,
     *     postcode: string,
     * }
     */
    public function getAttributes(): array
    {
        return [
            'name' => $this->name,
            'nip' => $this->nip,
            'address' => $this->address,
            'city' => $this->city,
            'postcode' => $this->postcode,
        ];
    }
}