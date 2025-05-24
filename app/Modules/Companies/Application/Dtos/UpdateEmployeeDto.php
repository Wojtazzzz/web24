<?php

declare(strict_types=1);

namespace App\Modules\Companies\Application\Dtos;

final readonly class UpdateEmployeeDto
{
    public function __construct(
        public int $employeeId,
        public string $firstName,
        public string $lastName,
        public string $email,
        public ?string $phone,
    ) {}

    /**
     * @return array{
     *     first_name: string,
     *     last_name: string,
     *     email: string,
     *     phone: ?string,
     * }
     */
    public function getAttributes(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone,
        ];
    }
}