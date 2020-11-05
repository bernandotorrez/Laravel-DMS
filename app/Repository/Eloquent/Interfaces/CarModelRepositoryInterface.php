<?php

namespace App\Repository\Eloquent\Interfaces;

use App\Models\CarModel;
use Illuminate\Support\Collection;

interface CarModelRepositoryInterface
{
    public function getAllData(): Collection;
}