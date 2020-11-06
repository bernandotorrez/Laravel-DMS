<?php

namespace App\Repository\Eloquent;

use App\Models\CarModel;
use App\Repository\Eloquent\BaseRepository;

class CarModelRepository extends BaseRepository
{
    public function __construct(CarModel $model)
    {
        parent::__construct($model, (new CarModel)->getKeyName());
    }

    
}