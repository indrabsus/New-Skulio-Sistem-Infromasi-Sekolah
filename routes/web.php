<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PureController;
use App\Http\Livewire\Admin\Index;
use App\Http\Livewire\Admin\UserAll;
use App\Http\Livewire\Kurikulum\GuruMgmt;
use App\Http\Livewire\Kurikulum\Kaprog;
use App\Http\Livewire\Kurikulum\KelasMgmt;
use App\Http\Livewire\Kurikulum\MapelMgmt;
use App\Http\Livewire\Kurikulum\SiswaMgmt;
use Illuminate\Support\Facades\Route;

// Route Auth
Route::get('/loginui', 'App\Http\Controllers\AuthController@index')->name('loginui');
Route::post('/proses_register', 'App\Http\Controllers\AuthController@proses_register')->name('proses_register');
Route::get('/login', 'App\Http\Controllers\AuthController@login')->name('loginredirect');
Route::post('proses_login', 'App\Http\Controllers\AuthController@proses_login')->name('proses_login');
Route::get('/logout', 'App\Http\Controllers\AuthController@logout')->name('logout');

// Route Web Home
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



Route::group(['middleware' => ['auth']], function () {

        // Livewire Admin
        Route::get('admin', Index::class)->name('index');
        Route::get('admin/userall', UserAll::class)->name('userAll');

        //livewire Kurikulum
        Route::get('admin/gurumgmt', GuruMgmt::class)->name('gurumgmt');
        Route::get('admin/siswamgmt', SiswaMgmt::class)->name('siswamgmt');
        Route::get('admin/kelasmgmt', KelasMgmt::class)->name('kelasmgmt');
        Route::get('admin/kaprog', Kaprog::class)->name('kaprog');
        Route::get('admin/mapelmgmt', MapelMgmt::class)->name('mapelmgmt');

        // Controller Config
        Route::get('admin/config', [PureController::class,'config'])->name('config');
        Route::post('admin/prosesconfig', [PureController::class,'prosesconfig'])->name('prosesConfig');

});
