<?php

declare(strict_types=1);

use App\Modules\Companies\Domain\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

uses(RefreshDatabase::class);

test('can update company', function () {
    $company = Company::factory()->createOne();

    $response = $this
        ->patchJson(route('companies.update', ['company' => $company]), [
            'name' => 'Company',
            'address' => 'Address',
            'nip' => '1234567890',
            'city' => 'City',
            'postcode' => '12-345',
        ])
        ->assertOk()
        ->assertValid();

    $company->refresh();

    $response->assertJson(fn (AssertableJson $json) => $json
        ->has('data', fn (AssertableJson $json) => $json
            ->where('id', $company->getKey())
            ->where('name', 'Company')
            ->where('address', 'Address')
            ->where('nip', '1234567890')
            ->where('city', 'City')
            ->where('postcode', '12-345'),
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
    $company = Company::factory()->createOne();

    $response = $this
        ->patchJson(route('companies.update', ['company' => $company]), [
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
            ->has('postcode'),
        )
        ->has('message'),
    );

    $this->assertDatabaseCount(new Company()->getTable(), 1);
    $this->assertDatabaseMissing(new Company()->getTable(), [
        'name' => 'Company',
        'address' => 'Address',
        'nip' => 'invalid',
        'city' => 'City',
        'postcode' => 'invalid',
    ]);
});
