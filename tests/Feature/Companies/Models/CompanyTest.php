<?php

declare(strict_types=1);

use App\Modules\Companies\Domain\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can create company', function () {
    $company = Company::factory()->createOne();

    $this->assertDatabaseHas(new Company()->getTable(), $company->getRawOriginal());
});
