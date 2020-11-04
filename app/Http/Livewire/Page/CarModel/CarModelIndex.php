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
    
    public $bindCarModel = [
        'id' => 0,
        'desc_model' => ''
    ];

    public bool $is_edit = false;
    public string $insert_status = '', $update_status = '', $delete_status = '';

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
        $this->sortBy = 'desc_model';
        $this->fill(request()->only('search', 'page'));
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

        $data = array('desc_model' => ucfirst($this->bindCarModel['desc_model']));

        $insert = $carModelRepository->create($data);

        if($insert) {
            $this->insert_status = 'success';
            $this->resetForm();
            $this->emit('closeModal');
        } else {
            $this->insert_status = 'fail';
        } 
    }

    public function showEditForm()
    {
        $this->insert_status = '';
        $this->update_status = '';
        $this->is_edit = true;

        $data = CarModel::where('id', $this->checked[0])->first();
        $this->bindCarModel['id'] = $data->id;
        $this->bindCarModel['desc_model'] = $data->desc_model;

        $this->emit('openModal');
    }

    public function editCarModel(CarModelRepository $carModelRepository)
    {
        $this->validate();

        $data = array('desc_model' => ucfirst($this->bindCarModel['desc_model']));

        $update = $carModelRepository->update($this->bindCarModel['id'], $data);

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
