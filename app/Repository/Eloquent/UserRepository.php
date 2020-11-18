<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function allUserEcxeptMePagination(
        string $search = '',
        string $sortBy,
        string $sortDirection = 'asc',
        int $perPage
    )
    {
        $arrayField = $this->searchableColumn;
        $countField = count($arrayField);

        $data = DB::table('view_user');
        $data = $data->where(function($query) use ($arrayField, $countField, $search) {
            if($countField >= 1) {
                for($i=0;$i <= $countField-1;$i++) {
                    if($i == 0) {
                        $query = $query->where($arrayField[$i], 'like', '%'.$search.'%');
                    } else {
                        $query = $query->orWhere($arrayField[$i], 'like', '%'.$search.'%');
                    }
                }
            }
        });
        $data = $data->where($this->primaryKey, '!=', Auth::id());
        $data = $data->orderBy($sortBy, $sortDirection);
        $data = $data->paginate($perPage);

        return $data;
    }

    public function allUserEcxeptMeChecked(
        string $search = '',
        string $sortBy,
        string $sortDirection = 'asc',
        int $perPage
    )
    {
        $arrayField = $this->searchableColumn;
        $countField = count($arrayField);

        $data = DB::table('view_user');
        $data = $data->select($this->primaryKey);
        $data = $data->where(function($query) use ($arrayField, $countField, $search) {
            if($countField >= 1) {
                for($i=0;$i <= $countField-1;$i++) {
                    if($i == 0) {
                        $query = $query->where($arrayField[$i], 'like', '%'.$search.'%');
                    } else {
                        $query = $query->orWhere($arrayField[$i], 'like', '%'.$search.'%');
                    }
                }
            }
        });
        $data = $data->where($this->primaryKey, '!=', Auth::id());
        $data = $data->orderBy($sortBy, $sortDirection);
        $data = $data->paginate($perPage);

        return $data;
    }
}