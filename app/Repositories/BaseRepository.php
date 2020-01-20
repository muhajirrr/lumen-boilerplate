<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;
    protected $perPage = 15;

    public function __construct(Model $model)
    {
        $this->model = $this->model;
    }

    public function all()
    {
        return $this->findBy([]);
    }

    public function findOne($id)
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function findOneBy(array $criteria)
    {
        return $this->model->where($criteria)->firstOrFail();
    }

    public function findBy(array $criteria)
    {
        $queryBuilder = $this->model->where($criteria);

        if ($this->shouldPaginate())
            return $queryBuilder->paginate($this->perPage);

        return $queryBuilder->get();
    }

    public function findIn($key, array $values)
    {
        $queryBuilder = $this->model->whereIn($key, $values);

        if ($this->shouldPaginate())
            return $queryBuilder->paginate($this->perPage);

        return $queryBuilder->get();
    }

    public function create(array $params)
    {
        return $this->model->create($params);
    }

    public function update(Model $model, array $params)
    {
        $model->update($params);

        // get updated model from database
        $model = $this->findOne($model->id);

        return $model;
    }

    public function delete(Model $model)
    {
        return $model->delete();
    }

    public function shouldPaginate() {
        if ($paginate = app('request')->input('paginate'))
            return filter_var($paginate, FILTER_VALIDATE_BOOLEAN);

        return true;
    }
}