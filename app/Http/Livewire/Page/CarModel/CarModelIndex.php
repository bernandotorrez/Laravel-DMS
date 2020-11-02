<?php

namespace App\Http\Livewire\Page\CarModel;

use Livewire\Component;
use App\Repository\Eloquent\Repo\CarModelRepository;
use App\Models\CarModel;
use Livewire\WithPagination;
use Livewire\WithSorting;

class CarModelIndex extends Component
{
    // Pagination
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public array $perPage = [10, 15, 20, 25];
    public int $perPageSelected = 10;
    public $page = 1;
    public string $sortBy = 'desc_model', $sortDirection = 'asc';
    // Pagination

    protected string $pageTitle = "Car Model";
    public $bindCarModel = [];
    public bool $is_edit = false;
    public int $id_checkbox = 0;
    public string $insert_status = '', $update_status = '', $delete_status = '', $search = '';
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];
    //public $car_model_data;
    
    // Datatable
    public bool $allChecked = false;
    public array $checked = [];
    // Datatable

    // Validation
    protected $rules = [
        'bindCarModel.desc_model' => 'required|min:3|max:50'
    ];

    protected $messages = [
        'bindCarModel.desc_model.required' => 'The Model Name Cant be Empty!',
        'bindCarModel.desc_model.min' => 'The Model Name must be at least 3 Characters',
        'bindCarModel.desc_model.max' => 'The Model Name Cant be maximal 50 Characters',
    ];
    // Validation

    public function mount()
    {
        $this->fill(request()->only('search', 'page'));
        $this->bindCarModel['id'] = 0;
        $this->bindCarModel['desc_model'] = '';
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function resetForm()
    {
        $this->reset(['bindCarModel']);
    }

    public function render()
    {
        $car_model_paginate = CarModel::where('desc_model', 'like', '%'.$this->search.'%')
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPageSelected);

        return view('livewire.page.car-model.car-model-index', [
            'car_model_paginate' => $car_model_paginate
        ])->layout('layouts.app', array('title' => $this->pageTitle));
    }

    public function addCarModel(CarModelRepository $carModelRepository)
    {
        $this->validate();

        $data = array('desc_model' => ucfirst($this->bindCarModel['desc_model']));

        $insert = $carModelRepository->create($data);

        if($insert) {
            $this->insert_status = 'success';
            $this->resetForm();
        } else {
            $this->insert_status = 'fail';
        }
    }

    public function showEditForm($data)
    {
        $this->is_edit = true;
        $this->bindCarModel['id'] = $data['id'];
        $this->bindCarModel['desc_model'] = $data['desc_model'];
    }

    public function editCarModel(CarModelRepository $carModelRepository)
    {
        $this->validate();

        $data = array('desc_model' => ucfirst($this->bindCarModel['desc_model']));

        $update = $carModelRepository->update($this->id_model, $data);

        if($update) {
            $this->update_status = 'success';
            $this->is_edit = false;
            $this->resetForm();
        } else {
            $this->update_status = 'fail';
        }
    }

    public function deleteCarModel($id, CarModelRepository $carModelRepository)
    {
        $delete = $carModelRepository->delete($id);

        if($delete) {
            $this->delete_status = 'success';
        } else {
            $this->delete_status = 'fail';
        }

    }

    public function sort($by)
    {
        $this->sortBy = $by;
        
        if($this->sortDirection == 'asc') {
            $this->sortDirection = 'desc';
        } else {
            $this->sortDirection = 'asc';
        }
    }

    public function allChecked()
    {
        $datas = CarModel::select('id')->get();

        // Dari Unchecked ke Checked
        if($this->allChecked == true) {
            foreach($datas as $data) {
                if(!in_array(intval($data->id), $this->checked)) {
                    array_push($this->checked, intval($data->id));
                }  
            }
        } else {
            // Checked ke Unchecked
            $this->checked = [];
        }
        
    }

    public function uncheckAll($id)
    {
        if($this->allChecked) {
            $key = array_search($id, $this->checked);
            if ($key !== false) {
                array_splice($this->checked, $key, 1);  
            } else {
                $this->checked = $this->checked;
            }
        }
        
    }
}
