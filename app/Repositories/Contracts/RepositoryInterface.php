<?php 

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function all();
    
    public function findOne($id);

    public function findOneBy(array $criteria);

    public function findBy(array $searchCriteria = []);

    public function findIn($key, array $values);

    public function create(array $params);

    public function update(Model $model, array $params);

    public function delete(Model $model);
}