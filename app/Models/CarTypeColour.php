<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CarTypeModel;

class CarTypeColour extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_type_colour_porsche';
    protected $primaryKey = 'id_type_colour';
    protected $fillable = ['id_type_model', 'colour'];
    protected $visible = ['id_type_colour', 'id_type_model', 'colour'];

    protected $searchableColumn = ['model_name', 'type_model_name', 'colour'];

    public function getSearchableColumn()
    {
        return $this->searchableColumn;
    }

    public function oneTypeModel()
    {
        return $this->belongsTo(CarTypeModel::class, 'id_type_model');
    }
}
