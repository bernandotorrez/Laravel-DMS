<?php

namespace App\Repository\Eloquent;
use App\Repository\Eloquent\BaseRepository;
use App\Models\UserGroup;

class AdminUserGroupRepository extends BaseRepository
{
    public function __construct(UserGroup $model)
    {
        parent::__construct($model);
    }
}