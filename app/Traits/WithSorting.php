<?php

namespace App\Traits;

trait WithSorting
{

    public string $sortBy, $sortDirection = 'asc';

    public function sortBy($field)
    {
        $this->sortBy = $field;

        $this->sortDirection = $this->sortBy === $field ? $this->reverseSort() : 'asc';
    }

    public function reverseSort()
    {
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }
}