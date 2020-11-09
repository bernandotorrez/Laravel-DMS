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
    protected $visible = ['id_model', 'model_name'];
    protected $searchableColumn = ['model_name'];

    public function typeModels()
    {
        return $this->hasMany(CarTypeModel::class, 'id_model');
    }
    
    protected static function booted()
    {
        static::deleting(function ($user) {
            // echo '<br>';
            // print_r($user);die;
        });
    }

    public function getSearchableColumn()
    {
        return $this->searchableColumn;
    }
}
