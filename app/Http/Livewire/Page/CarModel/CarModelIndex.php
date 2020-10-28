<?php

namespace App\Http\Livewire\Page\CarModel;

use Livewire\Component;
use App\Repository\Eloquent\Repo\CarModelRepository;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Collection;

class CarModelIndex extends Component
{
    protected string $pageTitle = "Car Model";
    public int $id_model = 0;
    public string $model_name = '';
    public string $insert_status = '', $update_status = '', $delete_status = '';
    public Collection $car_model_data;
    public bool $is_edit = false;

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

    public function showEditForm($data)
    {
        $this->is_edit = true;
        $this->id_model = $data['id'];
        $this->model_name = $data['desc_model'];
    }

    public function editCarModel(CarModelRepository $carModelRepository)
    {
        $this->validate();

        $data = array('desc_model' => ucfirst($this->model_name));

        $update = $carModelRepository->update($this->id_model, $data);

        if($update) {
            $this->update_status = 'success';
            $this->is_edit = false;
            $this->resetForm();
            $this->car_model_data = $carModelRepository->all();
        } else {
            $this->update_status = 'fail';
        }
    }

    public function deleteCarModel($id, CarModelRepository $carModelRepository)
    {
        $delete = $carModelRepository->delete($id);

        if($delete) {
            $this->delete_status = 'success';
            $this->car_model_data = $carModelRepository->all(); 
        } else {
            $this->delete_status = 'fail';
        }

    }
}
