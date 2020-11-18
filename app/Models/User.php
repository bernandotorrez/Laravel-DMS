<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\UserGroup;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'no_hp'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $primaryKey = 'id';
    protected $visible = ['id', 'name', 'email', 'no_hp', 'status'];
    protected $searchableColumn = ['id', 'name', 'email', 'no_hp', 'user_group'];

    public function getSearchableColumn()
    {
        return $this->searchableColumn;
    }

    public function oneUserGroup()
    {
        return $this->belongsTo(UserGroup::class, 'id_user_group');
    }
}
