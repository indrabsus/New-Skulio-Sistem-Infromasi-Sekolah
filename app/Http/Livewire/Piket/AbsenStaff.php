<?php

namespace App\Http\Livewire\Piket;

use App\Models\AbsenStaff as ModelsAbsenStaff;
use App\Models\AbsenTeacher;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AbsenStaff extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $id_tendik,$keterangan;
    public $result = 10;
    public $search = '';
    public function render()
    {

        return view('livewire.piket.absen-staff',[
            'data' => DB::table('absen_staff')
            ->leftJoin('stafs','stafs.id_staf','absen_staff.id_tendik')
            ->orderBy('id_tendik','desc')
            ->where('nama_staf', 'like', '%'.$this->search.'%')
            ->paginate($this->result),
            'tendik' => DB::table('stafs')
            ->get(),
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function clearForm(){
        $this->id_tendik = '';
        $this->keterangan = '';
    }
    public function create(){
        $this->validate([
            'id_tendik' => 'required',
            'keterangan' => 'required'
        ]);
        $hitung = DB::table('absen_staff')
        ->where('id_tendik', $this->id_tendik)
        ->where('tanggal', date('Y-m-d',strtotime(now())))
        ->count();
        if($hitung > 0){
            session()->flash('pesan','Jangan absen 2x');
        } elseif(date('l', strtotime(now())) == 'Sunday' || date('l', strtotime(now())) == 'Saturdayy'){
            session()->flash('pesan','Tidak bisa absen hari Sabtu dan Minggu');
        }else{
            $absen = ModelsAbsenStaff::create([
                'id_tendik' => $this->id_tendik,
                'tanggal' => now(),
                'waktu' => now(),
                'keterangan' => $this->keterangan
            ]);
            DB::table('staff_counts')->updateOrInsert([
                'bulan' => Carbon::parse(now())->translatedFormat('F Y'),
                'id_tendik' => $this->id_tendik,
                ],
                [
                    'total_absen' => DB::table('absen_staff')
                    ->where('keterangan', 'hadir')
                    ->where('id_tendik', $this->id_tendik)
                    ->where('tanggal', date('Y-m-d',strtotime(now())))
                    ->count() + DB::table('absen_staff')
                    ->where('keterangan', 'bdr')
                    ->where('id_tendik', $this->id_tendik)
                    ->where('tanggal', date('Y-m-d',strtotime(now())))
                    ->count() + DB::table('absen_staff')
                    ->where('keterangan', 'kegiatan')
                    ->where('id_tendik', $this->id_tendik)
                    ->where('tanggal', date('Y-m-d',strtotime(now())))
                    ->count() + DB::table('absen_staff')
                    ->where('id_tendik', $this->id_tendik)
                    ->where('tanggal', date('Y-m-d',strtotime(now())))
                    ->where('keterangan', 'nojadwal')
                    ->count(),
                    'hadir' => DB::table('absen_staff')
                    ->where('keterangan', 'hadir')
                    ->where('id_tendik', $this->id_tendik)
                    ->where('tanggal', date('Y-m-d',strtotime(now())))
                    ->count(),
                    'bdr' => DB::table('absen_staff')
                    ->where('keterangan', 'bdr')
                    ->where('id_tendik', $this->id_tendik)
                    ->where('tanggal', date('Y-m-d',strtotime(now())))
                    ->count(),
                    'sakit' => DB::table('absen_staff')
                    ->where('keterangan', 'sakit')
                    ->where('id_tendik', $this->id_tendik)
                    ->where('tanggal', date('Y-m-d',strtotime(now())))
                    ->count(),
                    'izin' => DB::table('absen_staff')
                    ->where('keterangan', 'izin')
                    ->where('id_tendik', $this->id_tendik)
                    ->where('tanggal', date('Y-m-d',strtotime(now())))
                    ->count(),
                    'kegiatan' => DB::table('absen_staff')
                    ->where('keterangan', 'kegiatan')
                    ->where('id_tendik', $this->id_tendik)
                    ->where('tanggal', date('Y-m-d',strtotime(now())))
                    ->count(),
                    'nojadwal' => DB::table('absen_staff')
                    ->where('id_tendik', $this->id_tendik)
                    ->where('tanggal', date('Y-m-d',strtotime(now())))
                    ->where('keterangan', 'nojadwal')
                    ->count()
                ]);
            session()->flash('pesan','Berhasil Absen');
            $this->clearForm();
        }


    }
}
