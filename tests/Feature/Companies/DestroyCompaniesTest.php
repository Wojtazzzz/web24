<?php

declare(strict_types=1);

use App\Modules\Companies\Domain\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;

uses(RefreshDatabase::class);

test('can delete company', function () {
    $company = Company::factory()->createOne();

    $this
        ->delete(route('companies.destroy', ['company' => $company]))
        ->assertNoContent();

    $this->assertDatabaseCount(new Company()->getTable(), 0);
});