<?php

namespace App\Repository\Eloquent\Repo;

use App\Models\CarModel;
use App\Repository\Eloquent\CRUDRepository;
use App\Repository\Eloquent\Interfaces\CarModelRepositoryInterface;

class CarModelRepository extends CRUDRepository implements CarModelRepositoryInterface
{
     /**
    * UserRepository constructor.
    *
    * @param CarModel $model
    */
    public function __construct(CarModel $model)
    {
        parent::__construct($model, (new CarModel)->getKeyName());
    }

}