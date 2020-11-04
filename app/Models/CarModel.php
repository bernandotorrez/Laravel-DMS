<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CarTypeModel;

class CarModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_model_porsche';
    protected $fillable = ['model_name'];
    protected $primaryKey = 'id_model';

    public function typeModels()
    {
        return $this->hasMany(CarTypeModel::class, 'id_model');
    }
    //public $incrementing = false;
}
