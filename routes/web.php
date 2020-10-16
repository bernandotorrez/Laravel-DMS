<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Home;
use App\Http\Livewire\About;
use App\Http\Middleware\Authenticate;
use App\Http\Controllers\Login;
use App\Http\Controllers\Register;
use App\Http\Controllers\Barang;
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

Route::resource('/login', Login::class)->names([
    'index' => 'login.index'
]);

Route::resource('/register', Register::class)->names([
    'index' => 'register.index',
    'do-register' => 'register.store'
]);

Route::middleware([Authenticate::class])->group(function() {   
    Route::get('/home', Home::class)->name('home');
    Route::get('/about', About::class)->name('about');
});

Route::resource('/barang', Barang::class);
