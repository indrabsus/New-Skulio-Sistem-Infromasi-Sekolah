<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PureController;
use Illuminate\Support\Facades\Config;
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

        // Livewire Admin Dashboard
        Route::get('admin', 'App\Http\Livewire\Admin\Index')->name('index');
        // Proses Controller
        Route::post('admin/prosesconfig', [PureController::class,'prosesconfig'])->name('prosesConfig');
        Route::post('/printdataguru', 'App\Http\Controllers\PrintController@dataguru')->name('printdataguru');
        Route::post('/printdatasiswa', 'App\Http\Controllers\PrintController@datasiswa')->name('printdatasiswa');
        Route::post('/printjadwal', 'App\Http\Controllers\PrintController@datajadwal')->name('printjadwal');
        Route::post('/printagendamanajerial', 'App\Http\Controllers\PrintController@agendamanajerial')->name('printagendamanajerial');
        Route::post('/printbos', 'App\Http\Controllers\PrintController@databos')->name('printdatabos');
        Route::post('/printsarpras', 'App\Http\Controllers\PrintController@datasarpras')->name('printdatasarpras');
        Route::post('/printcatatan', 'App\Http\Controllers\PrintController@datacatatan')->name('printdatacatatan');
        Route::post('/printabsenguru', 'App\Http\Controllers\PrintController@dataabsenguru')->name('printdataabsenguru');
        Route::post('/printabsentendik', 'App\Http\Controllers\PrintController@dataabsentendik')->name('printdataabsentendik');

        foreach (Config::get('menu') as $m) {
            Route::get($m->path, $m->class)->name($m->route);
        }
});

