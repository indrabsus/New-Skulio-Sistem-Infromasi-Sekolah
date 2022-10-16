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

Route::get('/loginui', 'App\Http\Controllers\AuthController@index')->name('loginui');
Route::post('/proses_register', 'App\Http\Controllers\AuthController@proses_register')->name('proses_register');
Route::get('/login', 'App\Http\Controllers\AuthController@login')->name('loginredirect');
Route::post('proses_login', 'App\Http\Controllers\AuthController@proses_login')->name('proses_login');
// Route::get('/logout', 'App\Http\Controllers\AuthController@logout')->name('logout');

// Route::get('/loginui',[PageController::class,'loginui'])->name('loginui');
Route::get('/',[PageController::class,'pengumuman'])->name('pengumuman');
Route::get('/guru',[PageController::class,'guru'])->name('dataguru');
Route::get('/tendik',[PageController::class,'tendik'])->name('datatendik');
Route::get('/mapel',[PageController::class,'mapel'])->name('datamapel');
Route::get('/kelas',[PageController::class,'kelas'])->name('datakelas');
Route::get('/siswa',[PageController::class,'siswa'])->name('datasiswa');
Route::get('/jadwal',[PageController::class,'jadwal'])->name('datajadwal');
Route::get('/labkom',[PageController::class,'labkom'])->name('datalabkom');
Route::get('/agendakepsek',[PageController::class,'kepsek'])->name('kepsekagenda');
Route::get('/agendakurikulum',[PageController::class,'kurikulum'])->name('kurikulumagenda');
Route::get('/agendakesiswaan',[PageController::class,'kesiswaan'])->name('kesiswaanagenda');
Route::get('/agendahumas',[PageController::class,'humas'])->name('humasagenda');
Route::get('/agendasarpras',[PageController::class,'sarpras'])->name('sarprasagenda');
Route::get('/agendamutu',[PageController::class,'mutu'])->name('mutuagenda');
Route::get('/bukutamu',[PageController::class,'tamu'])->name('bukutamu');
Route::post('/kirimtamu',[PageController::class,'kirimtamu'])->name('kirimtamu');


Route::middleware('auth:sanctum')->get('/logout', 'App\Http\Controllers\AuthController@logout')->name('logout');
Route::middleware('auth:sanctum')->get('/admin', 'App\Http\Controllers\AuthController@admin')->name('admin');
