<?php

namespace App\Http\Livewire\Page\CarModel;

use Livewire\Component;
use App\Models\CarModel;

class CarModelEdit extends Component
{

    public $data = [];
    public bool $update_status = false;

    public function mount($id)
    {
        $data = CarModel::where('id', $id)->get()->first();
        $this->data['id'] = $data->id;
        $this->data['desc_model'] = $data->desc_model;
    }

    public function render()
    {
        $layout = array('title' => "Edit Car Model");
        return view('livewire.page.car-model.car-model-edit')->layout('layouts.app', $layout);
    }
}
