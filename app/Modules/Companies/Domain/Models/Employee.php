<?php

declare(strict_types=1);

namespace App\Modules\Companies\Domain\Models;

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
final class Employee extends Model
{
    public $timestamps = false;

    public function company(): BelongsTo
    {
        return $this->belongsTo(
            related: Company::class,
            foreignKey: 'company_id',
            ownerKey: 'id',
        );
    }
}
