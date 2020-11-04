<?php

namespace App\Repository\Eloquent\Repo;

use App\Models\CarModel;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\Interfaces\CarModelRepositoryInterface;
use Illuminate\Support\Collection;

class CarModelRepository extends BaseRepository implements CarModelRepositoryInterface
{
    protected $primaryKey = 'id_model';
     /**
    * UserRepository constructor.
    *
    * @param CarModel $model
    */
    public function __construct(CarModel $model)
    {
        parent::__construct($model);
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
     * @param $id
     * 
     * @return Collection 
     */
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

    public function getByID($id): CarModel
    {
        return $this->model->where($this->primaryKey, $id)->first();
    }
}