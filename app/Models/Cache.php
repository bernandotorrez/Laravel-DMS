<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cache extends Model
{
    use HasFactory;

    protected $table = 'tbl_cache';
    protected $fillable = ['cache_name', 'id_user'];
    protected $visible = ['cache_name', 'id_user'];
}
