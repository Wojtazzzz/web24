<?php

declare(strict_types=1);

namespace App\Modules\Companies\Domain\Models;

use Database\Factories\Companies\EmployeeFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read Company $company
 * @property-read int $id
 * @property-read int $company_id
 * @property-read string $first_name
 * @property-read string $last_name
 * @property-read string $email
 * @property-read ?string $phone
 */
#[UseFactory(EmployeeFactory::class)]
final class Employee extends Model
{
    /** @use HasFactory<EmployeeFactory> */
    use HasFactory;

    public $timestamps = false;

    public function company(): BelongsTo
    {
        return $this->belongsTo(
            related: Company::class,
            foreignKey: 'company_id',
            ownerKey: 'id',
        );
    }

    protected function casts(): array
    {
        return [
            'phone' => 'string',
        ];
    }
}
