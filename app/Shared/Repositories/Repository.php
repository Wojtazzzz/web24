<?php

declare(strict_types=1);

namespace App\Shared\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use InvalidArgumentException;

abstract class Repository implements RepositoryInterface
{
    protected array $columns = ['*'];

    protected array $relations = [];

    /**
     * @var TModel
     */
    protected Model $model;

    protected bool $withFresh = true;

    public function __construct(protected Application $app)
    {
        $this->initializeModel($this->model());
    }

    abstract public function model(): string;

    public function getModel(): Model
    {
        return $this->model;
    }

    public function setColumns($columns = ['*']): self
    {
        $clone = clone $this;
        $clone->columns = is_array($columns) ? $columns : func_get_args();

        return $clone;
    }

    public function setRelations($relations = []): self
    {
        $clone = clone $this;
        $clone->relations = is_array($relations) ? $relations : func_get_args();

        return $clone;
    }

    public function withoutFreshModel(): self
    {
        return $this->setFreshModel(false);
    }

    public function withFreshModel(): self
    {
        return $this->setFreshModel();
    }

    public function setFreshModel(bool $fresh = true): self
    {
        $clone = clone $this;
        $clone->withFresh = $fresh;

        return $clone;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getRelations(): array
    {
        return $this->relations;
    }

    protected function initializeModel(string ...$model): mixed
    {
        return match (count($model)) {
            1 => $this->model = $this->app->make($model[0]),
            2 => $this->model = call_user_func([$this->app->make($model[0]), $model[1]]),
            default => throw new InvalidArgumentException('Model must be a FQDN or an array with a count of two.'),
        };
    }
}
