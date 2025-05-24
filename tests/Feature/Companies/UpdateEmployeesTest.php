<?php

declare(strict_types=1);

use App\Modules\Companies\Domain\Models\Company;
use App\Modules\Companies\Domain\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

uses(RefreshDatabase::class);

test('can update employee', function () {
    $company = Company::factory()->createOne();
    $employee = Employee::factory()->createOne([
        'company_id' => $company->getKey(),
    ]);

    $response = $this
        ->patchJson(route('companies.employees.update', ['company' => $company, 'employee' => $employee]), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'phone' => '123456789',
        ])
        ->assertOk()
        ->assertValid();

    $employee->refresh();

    $response->assertJson(fn (AssertableJson $json) => $json
        ->has('data', fn (AssertableJson $json) => $json
            ->where('id', $employee->getKey())
            ->where('first_name', 'John')
            ->where('last_name', 'Doe')
            ->where('email', 'john@doe.com')
            ->where('phone', '123456789')
            ->where('company.id', $company->getKey())
            ->etc(),
        ),
    );

    $this->assertDatabaseCount(new Employee()->getTable(), 1);
    $this->assertDatabaseHas(new Employee()->getTable(), [
        'company_id' => $company->getKey(),
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@doe.com',
        'phone' => '123456789',
    ]);
});

test('can update employee with nullable phone', function () {
    $company = Company::factory()->createOne();
    $employee = Employee::factory()->createOne([
        'company_id' => $company->getKey(),
    ]);

    $response = $this
        ->patchJson(route('companies.employees.update', ['company' => $company, 'employee' => $employee]), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'phone' => null,
        ])
        ->assertOk()
        ->assertValid();

    $employee->refresh();

    $response->assertJson(fn (AssertableJson $json) => $json
        ->has('data', fn (AssertableJson $json) => $json
            ->where('id', $employee->getKey())
            ->where('first_name', 'John')
            ->where('last_name', 'Doe')
            ->where('email', 'john@doe.com')
            ->where('phone', null)
            ->where('company.id', $company->getKey())
            ->etc(),
        ),
    );

    $this->assertDatabaseCount(new Employee()->getTable(), 1);
    $this->assertDatabaseHas(new Employee()->getTable(), [
        'company_id' => $company->getKey(),
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@doe.com',
        'phone' => null,
    ]);
});

test('cannot set invalid phone or email', function () {
    $company = Company::factory()->createOne();
    $employee = Employee::factory()->createOne([
        'company_id' => $company->getKey(),
    ]);

    $response = $this
        ->patchJson(route('companies.employees.update', ['company' => $company, 'employee' => $employee]), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'invalid',
            'phone' => 'invalid',
        ])
        ->assertStatus(422)
        ->assertInvalid([
            'email',
            'phone',
        ]);

    $response->assertJson(fn (AssertableJson $json) => $json
        ->has('errors', fn (AssertableJson $json) => $json
            ->has('email')
            ->has('phone')
        )
        ->has('message'),
    );

    $this->assertDatabaseCount(new Employee()->getTable(), 1);
    $this->assertDatabaseMissing(new Employee()->getTable(), [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'invalid',
        'phone' => 'invalid',
    ]);
});

test('cannot update employee who is not hired in pointed company', function () {
    $company = Company::factory()->createOne();
    $employee = Employee::factory()->createOne();

    $response = $this
        ->patchJson(route('companies.employees.update', ['company' => $company, 'employee' => $employee]), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'phone' => '123456789',
        ])
        ->assertNotFound()
        ->assertValid();

    $employee->refresh();

    $this->assertDatabaseCount(new Employee()->getTable(), 1);
    $this->assertDatabaseMissing(new Employee()->getTable(), [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'john@doe.com',
        'phone' => '123456789',
    ]);
});
