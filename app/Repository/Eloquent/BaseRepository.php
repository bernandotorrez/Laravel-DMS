<?php

namespace App\Repository\Eloquent;
use App\Repository\Eloquent\BaseInterface;

class BaseRepository implements BaseInterface
{
    protected $model;
    protected $primaryKey;

    public function __construct($model, $primaryKey)
    {
        $this->primaryKey = $primaryKey;
        $this->model = $model;
    }

    /**
     * Get All Data
     * @param array $colummn
     * @return Collection
     */
    public function all($column = ['*'])
    {
        return $this->model->all($column);
    }

    /**
     * Insert Data
     * @param array $data
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update Data
     * @param int $id
     * @param array $data
     */
    public function update(int $id, array $data)
    {
        return $this->model->where($this->primaryKey, $id)->update($data);
    }

    /**
     * Delete One Data
     * @param int
     */
    public function delete(int $id)
    {
        return $this->model->where($this->primaryKey, $id)->delete();
    }

    /**
     * Delete Many Data
     * @param int
     */
    public function massDelete(array $id)
    {
        return $this->model->whereIn($this->primaryKey, $id)->delete();
    }

    /**
     * Get Data By ID
     * @param int
     */
    public function getById(int $id)
    {
        return $this->model->where($this->primaryKey, $id)->get()->first();
    }

    /**
     * Get Data With Pagination
     * @param array $arrayField
     * @param string $search
     * @param string $sortBy
     * @param string $sortDirection
     * @param int $perPage
     */
    public function pagination(
        array $arrayField,
        string $search = '',
        string $sortBy,
        string $sortDirection = 'asc',
        int $perPage
    )
    {
        $countField = count($arrayField);

        $data = $this->model;
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
        $data = $data->orderBy($sortBy, $sortDirection);
        $data = $data->paginate($perPage);

        return $data;
    }

    public function checked(
        array $arrayField,
        string $search = '',
        string $sortBy,
        string $sortDirection = 'asc',
        int $perPage
    )
    {
        $countField = count($arrayField);

        $data = $this->model;
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
        $data = $data->orderBy($sortBy, $sortDirection);
        $data = $data->paginate($perPage);

        return $data;
    }
}