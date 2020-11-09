<?php

namespace App\Repository\Eloquent;

use App\Models\CarTypeModel;
use App\Repository\Eloquent\BaseRepository;

class CarTypeModelRepository extends BaseRepository
{
    public function __construct(CarTypeModel $model)
    {
        parent::__construct($model, (new $model)->getKeyName(), (new $model)->getVisible());
    }

    
}