<?php

declare(strict_types=1);

namespace Database\Factories\Companies;

use App\Modules\Companies\Domain\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Company>
 */
final class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'nip' => fake()->numberBetween(100000000, 999999999),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'postcode' => fake()->postcode(),
        ];
    }
}
