<?php

namespace App\Repository\Eloquent;

use App\Models\Barang;
use App\Repository\BarangRepositotyInterface;
use Illuminate\Support\Collection;

class BarangRepository extends BaseRepository implements BarangRepositotyInterface
{

   /**
    * BarangRepository constructor.
    *
    * @param Barang $model
    */
   public function __construct(Barang $model)
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
}