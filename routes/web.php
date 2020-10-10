<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware'=>['auth:sanctum', 'verified']], function (){
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/movie/favs', '\App\Http\Livewire\Movie\Favs')->name('movie.favs');
});
