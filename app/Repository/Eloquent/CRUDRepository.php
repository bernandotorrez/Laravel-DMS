<?php

namespace App\Repository\Eloquent;

use App\Repository\Eloquent\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CRUDRepository implements EloquentRepositoryInterface
{
    /**      
     * @var Model      
     */     
    protected $model;
    protected $primaryKey;

    /**      
     * BaseRepository constructor.      
     *      
     * @param Model $model      
     */
    public function __construct(Model $model, $primaryKey = 'id')
    {
        $this->model = $model;
        $this->primaryKey = $primaryKey;
    }

    /**
    * @return Collection
    */
    public function all(): Collection
    {
        return $this->model->all();    
    }

    /**
     * @param $id
     * 
     * @param array $attributes
     * 
     * @return Collection 
     */
    public function update(int $id, array $attributes): int
    {
        return $this->model->where($this->primaryKey, $id)->update($attributes);
    }

    /**
    * @param array $attributes
    *
    * @return Model
    */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    /**
    * @param $id
    * @return Model
    */
    public function find($id): ?Model {
        return $this->model->find($id);
    }

    public function delete(int $id): int
    {
        return $this->model->find($id)->delete();
    }

    public function massDelete(array $arrayId): int
    {
        return $this->model->whereIn($this->primaryKey, $arrayId)->delete();
    }

    public function paginate(int $int)
    {
        return $this->model->paginate($int);
    }

    public function datatablePagination(
        $where, 
        $search, 
        $sortBy, 
        $sortDirection, 
        $perPageSelected
        )
    {
        return $this->model->where($where, 'like', '%'.$search.'%')
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPageSelected);
    }

    public function datatablePaginationWithRelation(
        $where, 
        $search, 
        $sortBy, 
        $sortDirection, 
        $perPageSelected,
        $relation)
    {

        return $this->model->with($relation)->where($where, 'like', '%'.$search.'%')
            ->orderBy($sortBy, $sortDirection)
            ->paginate($perPageSelected);
    }

    public function getByID($id): ?Model
    {
        return $this->model->where($this->primaryKey, $id)->first();
    }
}