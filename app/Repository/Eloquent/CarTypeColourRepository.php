<?php

namespace App\Repository\Eloquent;
use App\Repository\Eloquent\BaseRepository;
use App\Models\CarTypeColour;

class CarTypeColourRepository extends BaseRepository
{
    public function __construct(CarTypeColour $model)
    {
        parent::__construct($model);
    }
}