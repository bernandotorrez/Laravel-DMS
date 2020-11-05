<?php

namespace App\Repository\Eloquent\Repo;

use App\Models\CarTypeModel;
use App\Repository\Eloquent\CRUDRepository;
use App\Repository\Eloquent\Interfaces\CarTypeModelRepositoryInterface;

class CarTypeModelRepository extends CRUDRepository
{
     /**
    * UserRepository constructor.
    *
    * @param CarModel $model
    */
    public function __construct(CarTypeModel $model)
    {
        parent::__construct($model, (new $model)->getKeyName());
    }

    public function deleteChild(array $arrayId)
    {
        return $this->model->whereIn('id_model', $arrayId)->delete();
    }

}