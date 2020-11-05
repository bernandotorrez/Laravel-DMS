<?php

namespace App\Repository\Eloquent\Repo;

use App\Models\CarModel;
use App\Repository\Eloquent\CRUDRepository;
use App\Repository\Eloquent\Interfaces\CarModelRepositoryInterface;
use Illuminate\Support\Collection;

class CarModelRepository extends CRUDRepository implements CarModelRepositoryInterface
{
     /**
    * UserRepository constructor.
    *
    * @param CarModel $model
    */
    public function __construct(CarModel $model)
    {
        parent::__construct($model, (new $model)->getKeyName());
    }

    /**
     * For Dropdown
     */
    public function getAllData(): Collection
    {
        return $this->model->select('id_model', 'model_name')->get();
    }

}