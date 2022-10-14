<?php

use App\Http\Controllers\PageController;
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

Route::get('/', 'App\Http\Controllers\AuthController@index')->name('login');
Route::get('/login', 'App\Http\Controllers\AuthController@login')->name('loginredirect');
Route::post('proses_login', 'App\Http\Controllers\AuthController@proses_login')->name('proses_login');
Route::get('/logout', 'App\Http\Controllers\AuthController@logout')->name('logout');

Route::get('/',[PageController::class,'pengumuman'])->name('pengumuman');
Route::get('/guru',[PageController::class,'guru'])->name('dataguru');
