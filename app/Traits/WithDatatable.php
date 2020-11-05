<?php


namespace App\Traits;
use App\Models\CarModel;
use Livewire\WithPagination;

trait WithDatatable
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public array $perPage = [10, 15, 20, 25, 50], $checked = [];
    public int $perPageSelected = 10;
    public string $search = '', $sortBy = '', $sortDirection = 'asc';

    public bool $allChecked = false;

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
