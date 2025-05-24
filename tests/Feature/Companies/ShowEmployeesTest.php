<?php

declare(strict_types=1);

use App\Modules\Companies\Domain\Models\Company;
use App\Modules\Companies\Domain\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

uses(RefreshDatabase::class);

test('can read company employee', function () {
    $company = Company::factory()->createOne();

    $employee = Employee::factory()->createOne([
        'company_id' => $company->getKey(),
    ]);

    $response = $this
        ->getJson(route('companies.employees.show', ['company' => $company, 'employee' => $employee]))
        ->assertOk();

    $response->assertJson(fn (AssertableJson $json) => $json
        ->has('data', fn (AssertableJson $json) => $json
            ->where('id', $employee->getKey())
            ->where('first_name', $employee->first_name)
            ->where('last_name', $employee->last_name)
            ->where('email', $employee->email)
            ->where('phone', $employee->phone)
            ->where('company.id', $company->getKey())
            ->etc(),
        ),
    );
});

test('cannot read employee who is not hired in pointed company', function () {
    $company = Company::factory()->createOne();
    $employee = Employee::factory()->createOne();

    $this
        ->getJson(route('companies.employees.show', ['company' => $company, 'employee' => $employee]))
        ->assertNotFound();
});
