<?php


namespace App\Traits;
use App\Models\CarModel;
use Livewire\WithPagination;

trait WithDatatable
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public array $perPage = [10, 15, 20, 25, 50];
    public int $perPageSelected = 10;
    public string $search = '';
    
    public string $sortBy = '';
    public string $sortDirection = 'asc';
    public bool $allChecked = false;
    public array $checked = [];

    public function sortBy($field)
    {
        $this->sortBy = $field;

        $this->sortDirection = $this->sortBy === $field ? $this->reverseSort() : 'asc';
    }

    public function reverseSort()
    {
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function allChecked()
    {
        $datas = CarModel::select('id')->where($this->sortBy, 'like', '%'.$this->search.'%')
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPageSelected);
      
        // Dari Unchecked ke Checked
        if($this->allChecked == true) {
            foreach($datas as $data) {
                if(!in_array($data->id, $this->checked)) {
                    array_push($this->checked, (string) $data->id);
                }
            }
        } else {
            // Checked ke Unchecked
            $this->checked = [];
        }

    }
}
