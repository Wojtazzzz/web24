<?php

declare(strict_types=1);

namespace App\Modules\Companies\Domain\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read Collection<int, Employee> $employees
 * @property-read int $id
 * @property-read string $name
 * @property-read string $nip
 * @property-read string $address
 * @property-read string $city
 * @property-read string $postcode
 */
final class Company extends Model
{
    public $timestamps = false;

    public function employees(): HasMany
    {
        return $this->hasMany(
            related: Employee::class,
            foreignKey: 'company_id',
            localKey: 'id',
        );
    }
}
