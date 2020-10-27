<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_model_porsche';
    protected $fillable = ['desc_model'];
}
