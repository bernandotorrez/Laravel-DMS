<?php

namespace App\Http\Livewire\Page\CarTypeModel;

use App\Models\CarTypeModel;
use App\Repository\Eloquent\Repo\CarModelRepository;
use App\Repository\Eloquent\Repo\CarTypeModelRepository;
use App\Traits\WithDatatable;
use Livewire\Component;

class CarTypeModelIndex extends Component
{
    use WithDatatable;

    protected string $pageTitle = 'Car Type Model';
    protected string $primaryKey = '';
    public bool $is_edit = false, $allChecked = false;
    public string $insert_status = '', $update_status = '', $delete_status = '';
    public array $checked = [];
    
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];

    public $bind = [
        'id_type_model' => 0,
        'id_model' => '',
        'type_model_name' => ''
    ];

    // Validation
    protected $rules = [
        'bind.id_model' => 'required',
        'bind.type_model_name' => 'required|min:3|max:50'
    ];

    protected $messages = [
        'bind.id_model.required' => 'The Model Name cant be Empty!',
        'bind.type_model_name.required' => 'The Type Model Name Cant be Empty!',
        'bind.type_model_name.min' => 'The Type Model Name must be at least 3 Characters',
        'bind.type_model_name.max' => 'The Type Model Name Cant be maximal 50 Characters',
    ];
    // Validation

    public function mount()
    {
        $this->sortBy = 'type_model_name';
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

    public function render(
        CarTypeModelRepository $carTypeModelRepository,
        CarModelRepository $carModelRepository
        )
    {
        $car_type_model = $carTypeModelRepository->datatablePaginationWithRelation(
            'type_model_name',
            $this->search,
            $this->sortBy,
            $this->sortDirection,
            $this->perPageSelected,
            'oneModel'
        );

        $car_model = $carModelRepository->getAllData();

        return view('livewire.page.car-type-model.car-type-model-index', [
            'car_type_model' => $car_type_model,
            'car_model' => $car_model
        ])
        ->layout('layouts.app', array('title' => $this->pageTitle));
    }

    public function allChecked()
    {
        $id = (new CarTypeModel)->getKeyName();

        $datas = CarTypeModel::select($id)->where($this->sortBy, 'like', '%'.$this->search.'%')
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPageSelected);
      
        // Dari Unchecked ke Checked
        if($this->allChecked == true) {
            foreach($datas as $data) {
                if(!in_array($data->$id, $this->checked)) {
                    array_push($this->checked, (string) $data->$id);
                }
            }
        } else {
            // Checked ke Unchecked
            $this->checked = [];
        }

    }

    public function addForm()
    {
        $this->insert_status = '';
        $this->update_status = '';
        $this->is_edit = false;
        $this->resetForm();

        $this->emit('openModal');
    }

    public function addProcess(CarTypeModelRepository $carTypeModelRepository)
    {
        $this->validate();

        $data = array(
            'id_model' => $this->bind['id_model'],
            'type_model_name' => ucfirst($this->bind['type_model_name'])
        );

        $insert = $carTypeModelRepository->create($data);

        if($insert) {
            $this->insert_status = 'success';
            $this->resetForm();
            $this->emit('closeModal');
        } else {
            $this->insert_status = 'fail';
        } 
    }
}
