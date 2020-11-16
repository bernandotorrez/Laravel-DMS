<?php

namespace App\Http\Livewire\Page\CarModel;

use App\Models\Cache as CacheModel;
use Livewire\Component;
use App\Models\CarModel;
use App\Repository\Eloquent\CarModelRepository;
use Livewire\WithPagination;
use App\Traits\WithSorting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CarModelIndex extends Component
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
    protected string $pageTitle = "Car Model";
    public bool $is_edit = false, $allChecked = false, $insertDuplicate = false;
    public string $insert_status = '', $update_status = '', $delete_status = '';
    public array $checked = [];
    
    protected $queryString = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];
    
    public $bind = [
        'id_model' => '',
        'model_name' => ''
    ];

    /**
     * Validation Attributes
     */
    protected $rules = [
        'bind.model_name' => 'required|min:3|max:50'
    ];

    protected $messages = [
        'bind.model_name.required' => 'The Model Name Cant be Empty!',
        'bind.model_name.min' => 'The Model Name must be at least 3 Characters',
        'bind.model_name.max' => 'The Model Name Cant be maximal 50 Characters',
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

    public function render(CarModelRepository $carModelRepository)
    {
        $cache_name = 'car-model-index-page-'.$this->page.'-pageselected-'.$this->perPageSelected.'-search-'.$this->search;
        $cache_name .= '-sortby-'.$this->sortBy.'-sortdirection-'.$this->sortDirection.'-user-'.Auth::id();

        $dataCarModel = Cache::remember($cache_name, 60, function () use ($carModelRepository, $cache_name) {
            CacheModel::firstOrCreate(['cache_name' => $cache_name, 'id_user' => Auth::id()]);
            return $carModelRepository->pagination(
                    $this->search,
                    $this->sortBy,
                    $this->sortDirection,
                    $this->perPageSelected
                );
        });

        return view('livewire.page.car-model.car-model-index', [
            'car_model_paginate' => $dataCarModel
        ])->layout('layouts.app', array('title' => $this->pageTitle));
    }

    public function allChecked(CarModelRepository $carModelRepository)
    {
        $datas = $carModelRepository->checked(
            $this->search,
            $this->sortBy,
            $this->sortDirection,
            $this->perPageSelected
        );

        $id = $carModelRepository->getPrimaryKey();
      
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

        //$this->dispatchBrowserEvent('swal');
        $this->emit('openModal');
    }

    public function addProcess(CarModelRepository $carModelRepository)
    {
        $this->validate();

        $data = array('model_name' => ucfirst($this->bind['model_name']));

        $count = $carModelRepository->findDuplicate($data);

        if($count <= 0) {
            $insert = $carModelRepository->create($data);

            if($insert) {
                $this->insert_status = 'success';
                $this->resetForm();
                $this->emit('closeModal');

                $this->deleteCache();
            } else {
                $this->insert_status = 'fail';
            }
        } else {
            $this->insertDuplicate = true;
        }
    }

    public function editForm(CarModelRepository $carModelRepository)
    {
        $this->insert_status = '';
        $this->update_status = '';
        $this->is_edit = true;

        $data = $carModelRepository->getByID($this->checked[0]);
        $this->bind['id_model'] = $data->id_model;
        $this->bind['model_name'] = $data->model_name;

        $this->emit('openModal');
    }

    public function editProcess(CarModelRepository $carModelRepository)
    {
        $this->validate();

        $data = array('model_name' => ucfirst($this->bind['model_name']));

        $count = $carModelRepository->findDuplicateEdit($data, $this->bind['id_model']);

        if($count >= 1) {
            $this->insertDuplicate = true;
        } else {
            $update = $carModelRepository->update($this->bind['id_model'], $data);

            if($update) {
                $this->update_status = 'success';
                $this->is_edit = false;
                $this->resetForm();
                $this->emit('closeModal');

                $this->deleteCache();
            } else {
                $this->update_status = 'fail';
            }
        }
        
    }

    public function deleteProcess(CarModelRepository $carModelRepository)
    {
        $delete = $carModelRepository->massDelete($this->checked);

        if($delete) {
            $this->delete_status = 'success';
            $this->resetForm();

            $this->deleteCache();
        } else {
            $this->delete_status = 'fail';
        }

        $this->emit('deleted', $this->delete_status);
    }

    private function deleteCache()
    {
        $dataCache = CacheModel::where('id_user', Auth::id())->get();

        foreach($dataCache as $cache)
        {
            Cache::forget($cache->cache_name);
        }

        CacheModel::where('id_user', Auth::id())->delete();
    }
}
