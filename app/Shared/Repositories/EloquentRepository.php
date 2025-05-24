<?php

declare(strict_types=1);

namespace App\Shared\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * @template TModel of Model
 */
abstract class EloquentRepository extends Repository implements RepositoryInterface
{
    public function getBuilder(): Builder
    {
        return $this->getModel()->newQuery();
    }

    /**
     * @return TModel
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @return TModel
     */
    public function find(int $id): Model
    {
        return $this->getBuilder()->findOrFail($id, $this->getColumns());
    }

    /**
     * @return Collection<TModel>
     */
    public function findWhere(array $fields): Collection
    {
        return $this->getBuilder()->where($fields)->get($this->getColumns());
    }

    /**
     * @return TModel
     *
     * @throws ModelNotFoundException
     */
    public function findFirstWhere(array $fields): Model
    {
        return $this->getBuilder()->with($this->getRelations())->where($fields)->firstOrFail($this->getColumns());
    }

    /**
     * @return TModel|bool
     */
    public function create(array $fields, bool $force = false): Model|bool
    {
        $instance = $this->getBuilder()->newModelInstance();
        ($force) ? $instance->forceFill($fields) : $instance->fill($fields);

        $saved = $instance->save();

        return ($this->withFresh) ? $instance->fresh() : $saved;
    }

    /**
     * @return TModel|bool
     */
    public function update(int $id, array $fields, bool $force = false): Model|bool
    {
        $instance = $this->getBuilder()->where('id', $id)->firstOrFail();

        ($force) ? $instance->forceFill($fields) : $instance->fill($fields);

        $saved = $instance->save();

        return ($this->withFresh) ? $instance->fresh() : $saved;
    }

    public function updateWhere(array $attributes, array $values): int
    {
        return $this->getBuilder()->where($attributes)->update($values);
    }

    public function delete(int $id, bool $destroy = false): int
    {
        return $this->deleteWhere(['id' => $id], $destroy);
    }

    public function deleteWhere(array $attributes, bool $force = false): int
    {
        $instance = $this->getBuilder()->where($attributes);

        return ($force) ? $instance->forceDelete() : $instance->delete();
    }
}
