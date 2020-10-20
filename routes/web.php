<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Home;
use App\Http\Livewire\About;
use App\Http\Livewire\Page\Login\LoginIndex;
use App\Http\Livewire\Page\Register\RegisterIndex;
use Illuminate\Support\Facades\Auth;

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
    Route::get('/home', Home::class)->name('home');
    Route::get('/about', About::class)->name('about');
});