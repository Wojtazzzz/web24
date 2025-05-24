<?php

declare(strict_types=1);

use App\Modules\Companies\Domain\Models\Company;
use App\Modules\Companies\Domain\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

uses(RefreshDatabase::class);

test('can create employee', function () {
    $company = Company::factory()->createOne();

    $response = $this
        ->postJson(route('companies.employees.store', ['company' => $company]), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'phone' => '123456789',
        ])
        ->assertCreated()
        ->assertValid();

    $employee = Employee::query()->firstOrFail();

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

test('can create employee with nullable phone', function () {
    $company = Company::factory()->createOne();

    $response = $this
        ->postJson(route('companies.employees.store', ['company' => $company]), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'phone' => null,
        ])
        ->assertCreated()
        ->assertValid();

    $employee = Employee::query()->firstOrFail();

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

    $response = $this
        ->postJson(route('companies.employees.store', ['company' => $company]), [
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

    $this->assertDatabaseCount(new Employee()->getTable(), 0);
});