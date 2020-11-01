<?php

namespace App\Http\Livewire;

use App\Models\CarModel;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\TableComponent;
use Rappasoft\LaravelLivewireTables\Traits\HtmlComponents;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Repository\Eloquent\Repo\CarModelRepository;

class CarModelTable extends TableComponent
{
    use HtmlComponents;

    public $perPage = 10;

    protected $options = [
        // The class set on the table when using bootstrap
        'bootstrap.classes.table' => 'table table-striped table-bordered',
    
        // The class set on the table's thead when using bootstrap
        'bootstrap.classes.thead' => null,
    
        // The class set on the table's export dropdown button
        'bootstrap.classes.buttons.export' => 'btn',
        
        // Whether or not the table is wrapped in a `.container-fluid` or not
        'bootstrap.container' => true,
        
        // Whether or not the table is wrapped in a `.table-responsive` or not
        'bootstrap.responsive' => true,
    ];

    public function query() : Builder
    {
        return CarModel::query();
    }

    public function columns() : array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->sortable(),
            Column::make('Name', 'desc_model')
                ->searchable()
                ->sortable(),
            Column::make('Action')
                ->format(function(CarModel $model) {
                    return $this->html('<button class="btn" wire:click="deleteCarModel('.$model->id.')"><i class="fas fa-trash-alt text-danger"></i> Delete</button>');
                })
        ];
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