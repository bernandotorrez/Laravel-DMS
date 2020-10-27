<?php

namespace App\Http\Livewire\Page\CarModel;

use Livewire\Component;

class CarModelIndex extends Component
{
    public $model_name;

    protected $rules = [
        'model_name' => 'required|min:3|max:50'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.page.car-model.car-model-index');
    }

    public function addCarModel() {
        $this->validate();

        dd($this->model_name);
    }
}
