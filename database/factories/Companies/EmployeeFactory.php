<?php

declare(strict_types=1);

namespace Database\Factories\Companies;

use App\Modules\Companies\Domain\Models\Company;
use App\Modules\Companies\Domain\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
final class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->email(),
            'phone' => fake()->randomElement([
                null,
                fake()->phoneNumber(),
            ]),
        ];
    }
}
