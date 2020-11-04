<?php

namespace App\Http\Livewire\Page\CarModel;

use Livewire\Component;
use App\Repository\Eloquent\Repo\CarModelRepository;
use App\Models\CarModel;
use Illuminate\Support\Facades\Cache;
use App\Traits\WithDatatable;

class CarModelIndex extends Component
{
    Use WithDatatable;

    protected string $pageTitle = "Car Model";
    
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];
    
    public $bind = [
        'id_model' => 0,
        'model_name' => ''
    ];

    public bool $is_edit = false;
    public string $insert_status = '', $update_status = '', $delete_status = '';

    // Validation
    protected $rules = [
        'bind.model_name' => 'required|min:3|max:50'
    ];

    protected $messages = [
        'bind.model_name.required' => 'The Model Name Cant be Empty!',
        'bind.model_name.min' => 'The Model Name must be at least 3 Characters',
        'bind.model_name.max' => 'The Model Name Cant be maximal 50 Characters',
    ];
    // Validation


   public function mount()
    {
        $this->sortBy = 'model_name';
        $this->fill(request()->only('search', 'page'));
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function resetForm()
    {
        $this->reset(['bind']);
    }

    public function render()
    {
        $car_model_paginate = CarModel::where('model_name', 'like', '%'.$this->search.'%')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPageSelected);

        return view('livewire.page.car-model.car-model-index', [
            'car_model_paginate' => $car_model_paginate
        ])->layout('layouts.app', array('title' => $this->pageTitle));
    }

    public function addForm()
    {
        $this->insert_status = '';
        $this->update_status = '';
        $this->is_edit = false;
        $this->resetForm();

        $this->emit('openModal');
    }

    public function addCarModel(CarModelRepository $carModelRepository)
    {
        $this->validate();

        $data = array('model_name' => ucfirst($this->bind['model_name']));

        $insert = $carModelRepository->create($data);

        if($insert) {
            $this->insert_status = 'success';
            $this->resetForm();
            $this->emit('closeModal');
        } else {
            $this->insert_status = 'fail';
        } 
    }

    public function showEditForm(CarModelRepository $carModelRepository)
    {
        $this->insert_status = '';
        $this->update_status = '';
        $this->is_edit = true;
       
        $data = $carModelRepository->getByID($this->checked[0]);
        $this->bind['id_model'] = $data->id_model;
        $this->bind['model_name'] = $data->model_name;

        $this->emit('openModal');
    }

    public function editCarModel(CarModelRepository $carModelRepository)
    {
        $this->validate();

        $data = array('model_name' => ucfirst($this->bind['model_name']));
        
        $update = $carModelRepository->update($this->bind['id_model'], $data);

        if($update) {
            $this->update_status = 'success';
            $this->is_edit = false;
            $this->resetForm();
            $this->emit('closeModal');
        } else {
            $this->update_status = 'fail';
        }
    }

    public function deleteCarModel(CarModelRepository $carModelRepository)
    {
        $delete = $carModelRepository->massDelete($this->checked);

        if($delete) {
            $this->allChecked = false;
            $this->checked = [];
            $this->delete_status = 'success';
        } else {
            $this->delete_status = 'fail';
        }

    }
}
