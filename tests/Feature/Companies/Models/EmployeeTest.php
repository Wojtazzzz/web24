<?php

declare(strict_types=1);

use App\Modules\Companies\Domain\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('can create employee', function () {
    $employee = Employee::factory()->createOne();

    $this->assertDatabaseHas(new Employee()->getTable(), $employee->getRawOriginal());
});
