<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Home;
use App\Http\Livewire\About;
use App\Http\Livewire\Page\Login\LoginIndex;
use App\Http\Livewire\Page\Register\RegisterIndex;
use App\Http\Middleware\Authenticate;
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

Route::get('/login', LoginIndex::class)->name('login.index');
Route::get('/register', RegisterIndex::class)->name('register.index');

Route::middleware([Authenticate::class])->group(function() {   
    Route::get('/home', Home::class)->name('home');
    Route::get('/about', About::class)->name('about');
});

Route::resource('/barang', Barang::class);
