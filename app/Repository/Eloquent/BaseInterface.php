<?php

namespace App\Repository\Eloquent;

interface BaseInterface 
{
    public function create(array $data);
    public function findDuplicate(array $data);
    public function update(string $id, array $data);
    public function delete(int $id);
    public function massDelete(array $id);
    public function all();
    public function getById(int $id);
}