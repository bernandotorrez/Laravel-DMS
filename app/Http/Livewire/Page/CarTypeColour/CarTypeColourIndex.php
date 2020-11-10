<?php

namespace App\Http\Livewire\Page\CarTypeColour;

use App\Repository\Eloquent\CarModelRepository;
use App\Repository\Eloquent\CarTypeColourRepository;
use App\Repository\Eloquent\CarTypeModelRepository;
use App\Traits\WithSorting;
use Livewire\Component;
use Livewire\WithPagination;

class CarTypeColourIndex extends Component
{

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
    protected string $pageTitle = "Car Type Colour";
    public bool $is_edit = false, $allChecked = false, $insertDuplicate = false, $updateDuplicate = false;
    public string $insert_status = '', $update_status = '', $delete_status = '', $viewName = 'view_colour_type_model_porsche';
    public array $checked = [];
    
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];
    
    public $bind = [
        'id_model' => '',
        'id_type_model' => '',
        'colour' => ''
    ];

    /**
     * Validation Attributes
     */
    protected $rules = [
        'bind.id_model' => 'required',
        'bind.id_type_model' => 'required',
        'bind.colour' => 'required|min:3|max:50'
    ];

    protected $messages = [
        'bind.id_model.required' => 'The Model Name cant be Empty!',
        'bind.id_type_model.required' => 'The Type Model Name cant be Empty!',
        'bind.colour.required' => 'The Colour Name Cant be Empty!',
        'bind.colour.min' => 'The Colour Name must be at least 3 Characters',
        'bind.colour.max' => 'The Colour Name Cant be maximal 50 Characters',
    ];

    public function mount()
    {
        $this->sortBy = 'model_name';
        $this->fill(request()->only('search', 'page'));
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
        $this->insertDuplicate = false;
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
        CarModelRepository $carModelRepository,
        CarTypeColourRepository $carTypeColourRepository
    )
    {
        $dataCarTypeColour = $carTypeModelRepository->viewPagination(
            $this->viewName,
            $this->search,
            $this->sortBy,
            $this->sortDirection,
            $this->perPageSelected
        );

        $dataCarModel = $carModelRepository->all(['id_model', 'model_name']);
        $dataCarTypeModel = $carTypeColourRepository->all(['id_type_model', 'type_model_name']);

        return view('livewire.page.car-type-colour.car-type-colour-index', [
                    'car_type_colour' => $dataCarTypeColour,
                    'car_model' => $dataCarModel,
                    'car_type_colour' => $dataCarTypeModel
                ])
                ->layout('layouts.app', array('title' => $this->pageTitle));
    }
}
