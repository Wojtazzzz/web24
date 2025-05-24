<?php

declare(strict_types=1);

use App\Modules\Companies\Domain\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

uses(RefreshDatabase::class);

test('can create company', function () {
    $response = $this
        ->postJson(route('companies.store'), [
            'name' => 'Company',
            'address' => 'Address',
            'nip' => '1234567890',
            'city' => 'City',
            'postcode' => '12-345',
        ])
        ->assertCreated()
        ->assertValid();

    $company = Company::query()->firstOrFail();

    $response->assertJson(fn (AssertableJson $json) => $json
        ->has('data', fn (AssertableJson $json) => $json
            ->where('id', $company->getKey())
            ->where('name', $company->name)
            ->where('address', $company->address)
            ->where('nip', $company->nip)
            ->where('city', $company->city)
            ->where('postcode', $company->postcode),
        ),
    );

    $this->assertDatabaseCount(new Company()->getTable(), 1);
    $this->assertDatabaseHas(new Company()->getTable(), [
        'name' => 'Company',
        'address' => 'Address',
        'nip' => '1234567890',
        'city' => 'City',
        'postcode' => '12-345',
    ]);
});

test('cannot set invalid nip or postcode', function () {
    $response = $this
        ->postJson(route('companies.store'), [
            'name' => 'Company',
            'address' => 'Address',
            'nip' => 'invalid',
            'city' => 'City',
            'postcode' => 'invalid',
        ])
        ->assertStatus(422)
        ->assertInvalid([
            'nip',
            'postcode',
        ]);

    $response->assertJson(fn (AssertableJson $json) => $json
        ->has('errors', fn (AssertableJson $json) => $json
            ->has('nip')
            ->has('postcode')
        )
        ->has('message'),
    );

    $this->assertDatabaseCount(new Company()->getTable(), 0);
});
