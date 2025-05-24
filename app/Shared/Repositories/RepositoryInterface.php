<?php

declare(strict_types=1);

namespace App\Shared\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function model(): string;

    public function getModel(): Model;

    public function getBuilder(): Builder;

    public function getColumns(): array;

    public function setColumns(array|string $columns = ['*']): self;

    public function find(int $id): mixed;

    public function findWhere(array $fields): Collection;

    public function findFirstWhere(array $fields): mixed;

    public function update(int $id, array $fields, bool $force = false): Model|bool;

    public function updateWhere(array $attributes, array $values): int;

    public function delete(int $id, bool $destroy = false): int;

    public function deleteWhere(array $attributes, bool $force = false): int;

    public function withoutFreshModel(): self;

    public function withFreshModel(): self;
}
