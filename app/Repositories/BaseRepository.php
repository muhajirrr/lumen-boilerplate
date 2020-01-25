<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseRepository
{
    protected $model;
    protected $perPage = 15;
    protected $useUuid = true;
    protected $useSlug = true;
    protected $slugKey = 'nama';

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
        $model = $this->model->newInstance($params);

        if ($this->useUuid)
            $model->id = Str::uuid()->toString();

        if ($this->useSlug)
            $model->slug = Str::slug($model->{$this->slugKey});

        $model->save();

        return $model;
    }

    public function update(Model $model, array $params)
    {
        $model->fill($params);

        if ($this->useSlug)
            $model->slug = Str::slug($model->{$this->slugKey});
            
        $model->save();

        return $model;
    }

    public function delete(Model $model)
    {
        return $model->delete();
    }

    public function shouldPaginate()
    {
        if ($paginate = app('request')->input('paginate'))
            return filter_var($paginate, FILTER_VALIDATE_BOOLEAN);

        return true;
    }
}