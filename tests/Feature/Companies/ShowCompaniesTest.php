<?php

declare(strict_types=1);

use App\Modules\Companies\Domain\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

uses(RefreshDatabase::class);

test('can read company', function () {
    $company = Company::factory()->createOne();

    $response = $this
        ->getJson(route('companies.show', ['company' => $company]))
        ->assertOk();

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
});