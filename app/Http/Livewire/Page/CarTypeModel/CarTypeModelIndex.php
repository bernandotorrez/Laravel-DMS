<?php

namespace App\Http\Livewire\Page\CarTypeModel;

use App\Models\CarTypeModel;
use App\Repository\Eloquent\CarModelRepository;
use App\Repository\Eloquent\CarTypeModelRepository;
use App\Traits\WithDatatable;
use App\Traits\WithSorting;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CarTypeModelIndex extends Component
{
    // use WithDatatable;

    // protected string $pageTitle = 'Car Type Model';
    // protected string $primaryKey = '';
    // public bool $is_edit = false, $allChecked = false;
    // public string $insert_status = '', $update_status = '', $delete_status = '';
    // public array $checked = [];
    
    // protected $queryString = [
    //     'search' => ['except' => ''],
    //     'page' => ['except' => 1]
    // ];

    // public $bind = [
    //     'id_type_model' => 0,
    //     'id_model' => '',
    //     'type_model_name' => ''
    // ];

    // // Validation
    // protected $rules = [
    //     'bind.id_model' => 'required',
    //     'bind.type_model_name' => 'required|min:3|max:50'
    // ];

    // protected $messages = [
    //     'bind.id_model.required' => 'The Model Name cant be Empty!',
    //     'bind.type_model_name.required' => 'The Type Model Name Cant be Empty!',
    //     'bind.type_model_name.min' => 'The Type Model Name must be at least 3 Characters',
    //     'bind.type_model_name.max' => 'The Type Model Name Cant be maximal 50 Characters',
    // ];
    // // Validation

    // public function mount()
    // {
    //     $this->sortBy = 'type_model_name';
    //     $this->fill(request()->only('search', 'page'));
    // }

    // public function updated($propertyName)
    // {
    //     $this->validateOnly($propertyName);
    // }

    // public function resetForm()
    // {
    //     $this->reset(['bind']);
    // }

    // public function render(
    //     CarModelRepository $carModelRepository
    //     )
    // {
    //     // $car_type_model = $carTypeModelRepository->datatablePaginationWithRelation(
    //     //     'type_model_name',
    //     //     ['model_name'],
    //     //     $this->search,
    //     //     $this->sortBy,
    //     //     $this->sortDirection,
    //     //     $this->perPageSelected,
    //     //     'oneModel'
    //     // );

    //     $car_type_model = DB::table('view_type_model_porsche')
    //     ->where($this->sortBy, 'like', '%'.$this->search.'%')
    //     ->orderBy($this->sortBy, $this->sortDirection)
    //     ->paginate($this->perPageSelected);

    //     $car_model = $carModelRepository->getAllData();

    //     return view('livewire.page.car-type-model.car-type-model-index', [
    //         'car_type_model' => $car_type_model,
    //         'car_model' => $car_model
    //     ])
    //     ->layout('layouts.app', array('title' => $this->pageTitle));
    // }

    // public function allChecked()
    // {
    //     $id = (new CarTypeModel)->getKeyName();

    //     $datas = DB::table('view_type_model_porsche')
    //     ->select($id)
    //     ->where($this->sortBy, 'like', '%'.$this->search.'%')
    //     ->orderBy($this->sortBy, $this->sortDirection)
    //     ->paginate($this->perPageSelected);
      
    //     // Dari Unchecked ke Checked
    //     if($this->allChecked == true) {
    //         foreach($datas as $data) {
    //             if(!in_array($data->$id, $this->checked)) {
    //                 array_push($this->checked, (string) $data->$id);
    //             }
    //         }
    //     } else {
    //         // Checked ke Unchecked
    //         $this->checked = [];
    //     }

    // }

    // public function addForm()
    // {
    //     $this->insert_status = '';
    //     $this->update_status = '';
    //     $this->is_edit = false;
    //     $this->resetForm();

    //     $this->emit('openModal');
    // }

    // public function addProcess(CarTypeModelRepository $carTypeModelRepository)
    // {
    //     $this->validate();

    //     $data = array(
    //         'id_model' => $this->bind['id_model'],
    //         'type_model_name' => ucfirst($this->bind['type_model_name'])
    //     );

    //     $insert = $carTypeModelRepository->create($data);

    //     if($insert) {
    //         $this->insert_status = 'success';
    //         $this->resetForm();
    //         $this->emit('closeModal');
    //     } else {
    //         $this->insert_status = 'fail';
    //     } 
    // }

    use WithPagination;
    use WithSorting;

    /**
     * Pagination Attributes
     */
    protected $paginationTheme = 'bootstrap';
    public array $perPage = [10, 15, 20, 25, 50];
    public int $perPageSelected = 10;
    public string $search = '';

    /**
     * Page Attributes
     */
    protected string $pageTitle = "Car Model";
    public bool $is_edit = false, $allChecked = false;
    public string $insert_status = '', $update_status = '', $delete_status = '', $viewName = 'view_type_model_porsche';
    public array $checked = [];
    
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];
    
    public $bind = [
        'id_model' => 0,
        'model_name' => ''
    ];

    /**
     * Validation Attributes
     */
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

    public function mount()
    {
        $this->sortBy = 'model_name';
        $this->fill(request()->only('search', 'page'));
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatingSearch()
    {
        $this->resetPage();
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
        $dataCarTypeModel = $carTypeModelRepository->viewPagination(
            $this->viewName,
            $carTypeModelRepository->getColumn(),
            $this->search,
            $this->sortBy,
            $this->sortDirection,
            $this->perPageSelected
        );

        $dataCarModel = $carModelRepository->all(['id_model', 'model_name']);

        return view('livewire.page.car-type-model.car-type-model-index', [
                    'car_type_model' => $dataCarTypeModel,
                    'car_model' => $dataCarModel
                ])
                ->layout('layouts.app', array('title' => $this->pageTitle));
    }

    public function allChecked(CarTypeModelRepository $carTypeModelRepository)
    {
        $datas = $carTypeModelRepository->viewChecked(
            $this->viewName,
            $carTypeModelRepository->getColumn(),
            $this->search,
            $this->sortBy,
            $this->sortDirection,
            $this->perPageSelected
        );

        $id = $carTypeModelRepository->getPrimaryKey();
      
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
}
