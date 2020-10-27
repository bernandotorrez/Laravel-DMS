<?php

namespace App\Http\Livewire\Page\CarModel;

use Livewire\Component;
use App\Repository\Eloquent\Repo\CarModelRepository;
use Ramsey\Uuid\Uuid;

class CarModelIndex extends Component
{
    protected $pageTitle = "Car Model";
    public $model_name;
    public $insert_status;
    public $car_model_data = [];

    protected $rules = [
        'model_name' => 'required|min:3|max:50'
    ];

    public function mount(CarModelRepository $carModelRepository)
    {
        $this->car_model_data = $carModelRepository->all();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function resetForm()
    {
        $this->reset(['model_name']);
    }

    public function render()
    {
        $data = array('car_model_data' => $this->car_model_data);
        return view('livewire.page.car-model.car-model-index', $data)->layout('layouts.app', array('title' => $this->pageTitle));
    }

    public function addCarModel(CarModelRepository $carModelRepository)
    {
        $this->validate();

        $data = array('desc_model' => ucfirst($this->model_name));

        $insert = $carModelRepository->create($data);

        if($insert) {
            $this->insert_status = 'success';
            $this->resetForm();
            $this->car_model_data = $carModelRepository->all();
        } else {
            $this->insert_status = 'fail';
        }
    }
}
