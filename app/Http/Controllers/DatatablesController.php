<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarModel;
use Datatables;

class DatatablesController extends Controller
{
    public function carModelJson()
    {
        $data = CarModel::select('id', 'desc_model');

        return Datatables::of($data)
        ->addColumn('action', function($data) {
            return '<input type="checkbox" class="new-control-input" data-id='.$data->id.' 
            wire:key='.$data->id.' wire:click="updateId('.$data->id.')">';
        })
        ->make(true);
    }
}
