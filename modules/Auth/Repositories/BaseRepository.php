<?php

namespace Modules\Auth\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository
{
    private Model $model;

    protected string $modelClass;

    public function __construct()
    {
        if (! class_exists($this->modelClass)) {
            throw new \InvalidArgumentException("Class {$this->modelClass} does not exist.");
        }

        $this->model = new $this->modelClass();
    }

    public function all(array $columns = ['*']): Collection
    {
        return $this->model->all($columns);
    }

    public function paginate(?int $limit = null, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->model->select($columns)->latest()->paginate($limit);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function find(int|string $id): ?Model
    {
        return $this->model->find($id);
    }

    public function findOrFail(int|string $id): Model|Collection
    {
        return $this->model->findOrFail($id);
    }

    public function update(Model $entity, array $data): bool
    {
        return $entity->update($data);
    }

    public function delete(Model $entity): ?bool
    {
        return $entity->delete();
    }

    public function updateOrCreate(array $attributes, array $values): Model
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    public function getBy(array $condition = [], bool $takeOne = false): Collection|Model|null
    {
        $result = $this->model->where($condition);

        if ($takeOne) {
            return $result->first();
        }

        return $result->get();
    }
}
