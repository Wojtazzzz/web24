<?php

declare(strict_types=1);

use App\Modules\Companies\Domain\Models\Company;
use App\Modules\Companies\Domain\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

uses(RefreshDatabase::class);

test('can read company employees', function (int $count) {
    $company = Company::factory()->createOne();

    Employee::factory($count)->create([
        'company_id' => $company->getKey(),
    ]);

    Employee::factory(3)->create();

    $response = $this
        ->getJson(route('companies.employees.index', ['company' => $company]))
        ->assertOk();

    $employees = Employee::query()
        ->where('company_id', $company->getKey())
        ->latest('id')
        ->get();

    $employees->each(fn (Employee $employee, $index) => $response
        ->assertJson(fn (AssertableJson $json) => $json
            ->has('data', $count)
            ->has("data.$index", fn (AssertableJson $json) => $json
                ->where('id', $employee->getKey())
                ->where('first_name', $employee->first_name)
                ->where('last_name', $employee->last_name)
                ->where('email', $employee->email)
                ->where('phone', $employee->phone)
                ->where('company.id', $company->getKey())
                ->etc(),
            ),
        ),
    );
})->with([1, 3, 8]);