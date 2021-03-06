<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Page\Home\HomeIndex;
use App\Http\Livewire\Page\About\AboutIndex;
use App\Http\Livewire\Page\Login\LoginIndex;
use App\Http\Livewire\Page\Register\RegisterIndex;
use App\Http\Livewire\Page\CarModel\CarModelIndex;
use App\Http\Livewire\Page\CarTypeModel\CarTypeModelIndex;
use App\Http\Livewire\Page\CarTypeColour\CarTypeColourIndex;
use App\Http\Livewire\Page\Admin\UserGroup\UserGroupIndex;
use App\Http\Livewire\Page\Admin\UserAccount\UserAccountIndex;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\Page\TestDetail\TestDetailIndex;
use App\Models\CarTypeModel;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect(route('login.index'));
});

Route::get('/login', LoginIndex::class)->name('login.index');
Route::get('/register', RegisterIndex::class)->name('register.index');
Route::get('/logout', function() {
    Auth::logout();

    return redirect()->route('login.index');
})->name('logout');

Route::middleware('auth')->group(function() {   
    Route::get('/home', HomeIndex::class)->name('home.index');
    Route::get('/about', AboutIndex::class)->name('about.index');

    Route::get('/car-model', CarModelIndex::class)->name('car-model.index');

    Route::get('/car-type-model', CarTypeModelIndex::class)->name('car-type-model.index');

    Route::get('/car-type-colour', CarTypeColourIndex::class)->name('car-type-colour.index');
    
    Route::get('/test-detail', TestDetailIndex::class)->name('test-detail.index');

    Route::prefix('admin')->group(function() {
        Route::get('user-group', UserGroupIndex::class)->name('admin.user-group.index');
        Route::get('user-account', UserAccountIndex::class)->name('admin.user-account.index');
    });
    
    Route::get('/tes', function() {
        $data = CarTypeModel::with('oneModel');
        
        $data->chunk(100, function($tes) {
            foreach($tes as $x) {
                echo 'ID Model : '.$x->id_model;
                echo ' ID Type Model : '.$x->id_type_model;
                echo ' Model Name : '.$x->oneModel->model_name;
                echo ' Type Model Name : '.$x->type_model_name;
                echo '<br>';
            }
        });
        
    });
});