<?php

namespace App\Repositories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;

abstract class AbstractRepository extends BaseRepository
{
    /**
     * @return \Illuminate\Database\Eloquent\Model
     * @throws RepositoryException
     */
    public function makeModel()
    {
        return parent::makeModel();
    }

    public function findOneByFields(array $fields, $columns = ['*'])
    {
        $this->applyCriteria();
        $this->applyScope();
        $this->applyConditions($fields);
        $model = $this->model->first($columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

    public function findOneByField($field, $value = null, $columns = ['*']): ?\Illuminate\Database\Eloquent\Model
    {
        $this->applyCriteria();
        $this->applyScope();
        $model = $this->model->where($field, '=', $value)->first($columns);
        $this->resetModel();

        return $this->parserResult($model);
    }

    public function whereUrl(string $url): Builder
    {
        return $this->where('url', $url);
    }

    public function findByUrl(string $url)
    {
        return $this->whereUrl($url)->first();
    }

    public function update(array $attributes, $id)
    {
        $methodExists = (is_object($id) && method_exists($id, 'fillExisting'));
        $isModel = ($id instanceof Model);

        $model = ($methodExists || $isModel) ? $id : $this->find($id);

        if (!$model) {
            return null;
        }

        $model->fillExisting($attributes)->save();

        return $model;
    }

    /**
     * @throws RepositoryException
     */
    public function updateFirstWhere(array $attributes, array $where)
    {
        $this->applyConditions($where);
        $model = $this->first();
        if (!$model) {
            return null;
        }
        $model->fillExisting($attributes)->save();

        return $model;
    }

    public function create(array $attributes)
    {
        $res = ($entity = $this->makeModel())->fillExisting($attributes)->save();
        if (!$res) {
            return null;
        }

        return $entity;
    }

    public function delete($id)
    {
        if ($id instanceof \Illuminate\Database\Eloquent\Model) {
            $id = $id->getKey();
        }
        return parent::delete($id);
    }

    public function deleteWhereIn(array $ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

    public function whereModel(\Illuminate\Database\Eloquent\Model $model)
    {
        $this->model = $this->model->where($model->getForeignKey(), $model->getKey());
        return $this;
    }

    public function createRelated(array $attributes, \Illuminate\Database\Eloquent\Model $model)
    {
        $attributes[$model->getForeignKey()] = $model->getKey();
        return $this->create($attributes);
    }

    public function createParent(array $attributes, \Illuminate\Database\Eloquent\Model $model)
    {
        $attributes['parent_id'] = $model->getKey();
        return $this->create($attributes);
    }

    protected function initBuilder(): Builder
    {
        return $this->model = $this->model->newQuery();
    }
}
