<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CarModel;

class CarTypeModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_type_model_porsche';
    protected $fillable = ['id_model', 'type_model_name'];
    protected $primaryKey = 'id_type_model';
    protected $visible = ['id_type_model', 'id_model', 'model_name', 'type_model_name'];
    protected $searchableColumn = ['model_name', 'type_model_name'];

    public function oneModel()
    {
        return $this->belongsTo(CarModel::class, 'id_model');
    }

    public function getSearchableColumn()
    {
        return $this->searchableColumn;
    }
}
