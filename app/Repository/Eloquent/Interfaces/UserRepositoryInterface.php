<?php

namespace App\Repository\Eloquent\Interfaces;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function all(): Collection;

    /**
     * @param $id
     * 
     * @param array $attributes
     * 
     * @return Collection 
     */
    public function update(int $id, array $attributes): Collection;

    /**
     * @param $id
     * 
     * @return Collection 
     */
    public function delete(int $id): Collection;
}