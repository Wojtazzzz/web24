<?php

declare(strict_types=1);

use App\Modules\Companies\Domain\Models\Company;
use App\Modules\Companies\Domain\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can delete employee', function () {
    $company = Company::factory()->createOne();
    $employee = Employee::factory()->createOne([
        'company_id' => $company->getKey(),
    ]);

    $this
        ->delete(route('companies.employees.destroy', ['company' => $company, 'employee' => $employee]))
        ->assertNoContent();

    $this->assertDatabaseCount(new Company()->getTable(), 1);
    $this->assertDatabaseCount(new Employee()->getTable(), 0);
});

test('cannot delete employee who is not hired in pointed company', function () {
    $company = Company::factory()->createOne();
    $employee = Employee::factory()->createOne();

    $this
        ->delete(route('companies.employees.destroy', ['company' => $company, 'employee' => $employee]))
        ->assertNotFound();

    $this->assertDatabaseCount(new Company()->getTable(), 2);
    $this->assertDatabaseCount(new Employee()->getTable(), 1);
});
