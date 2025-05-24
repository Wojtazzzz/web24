<?php

declare(strict_types=1);

use App\Modules\Companies\Domain\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

uses(RefreshDatabase::class);

test('can read companies', function (int $count) {
    Company::factory($count)->create();

    $response = $this
        ->getJson(route('companies.index'))
        ->assertOk();

    $companies = Company::query()->latest('id')->get();

    $companies->each(fn (Company $company, $index) => $response
        ->assertJson(fn (AssertableJson $json) => $json
            ->has('data', $count)
            ->has("data.$index", fn (AssertableJson $json) => $json
                ->where('id', $company->getKey())
                ->where('name', $company->name)
                ->where('address', $company->address)
                ->where('nip', $company->nip)
                ->where('city', $company->city)
                ->where('postcode', $company->postcode)
                ->etc(),
            ),
        ),
    );
})->with([1, 3, 8]);