<?php

namespace App\Http\Livewire\Piket;

use App\Models\AbsenTeacher;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AbsenGuru extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $id_guru,$keterangan;
    public $result = 10;
    public $search = '';
    public function render()
    {

        return view('livewire.piket.absen-guru',[
            'data' => DB::table('absen_teachers')
            ->leftJoin('teachers','teachers.id_guru','absen_teachers.id_guru')
            ->orderBy('id_absen','desc')
            ->where('nama_guru', 'like', '%'.$this->search.'%')
            ->paginate($this->result),
            'guru' => DB::table('teachers')
            ->get(),
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function clearForm(){
        $this->id_guru = '';
        $this->keterangan = '';
    }
    public function create(){
        $this->validate([
            'id_guru' => 'required',
            'keterangan' => 'required'
        ]);
        $hitung = DB::table('absen_teachers')
        ->where('id_guru', $this->id_guru)
        ->where('tanggal', date('Y-m-d',strtotime(now())))
        ->count();
        if($hitung > 0){
            session()->flash('pesan','Jangan absen 2x');
        } elseif(date('l', strtotime(now())) == 'Sunday' || date('l', strtotime(now())) == 'Saturday'){
            session()->flash('pesan','Tidak bisa absen hari Sabtu dan Minggu');
        }else{
            $absen = AbsenTeacher::create([
                'id_guru' => $this->id_guru,
                'tanggal' => now(),
                'waktu' => now(),
                'keterangan' => $this->keterangan
            ]);
            DB::table('teacher_counts')->updateOrInsert([
                'bulan' => Carbon::parse(now())->translatedFormat('F Y'),
                'id_guru' => $this->id_guru,
                ],
                [
                    'total_absen' => DB::table('absen_teachers')
                    ->where('keterangan', 'hadir')
                    ->where('id_guru', $this->id_guru)
                    ->where('tanggal', 'like', '%'.date('Y-m',strtotime(now())).'%')
                    ->count() + DB::table('absen_teachers')
                    ->where('keterangan', 'bdr')
                    ->where('id_guru', $this->id_guru)
                    ->where('tanggal', 'like', '%'.date('Y-m',strtotime(now())).'%')
                    ->count() + DB::table('absen_teachers')
                    ->where('keterangan', 'kegiatan')
                    ->where('id_guru', $this->id_guru)
                    ->where('tanggal', 'like', '%'.date('Y-m',strtotime(now())).'%')
                    ->count() + DB::table('absen_teachers')
                    ->where('id_guru', $this->id_guru)
                    ->where('tanggal', 'like', '%'.date('Y-m',strtotime(now())).'%')
                    ->where('keterangan', 'nojadwal')
                    ->count(),
                    'hadir' => DB::table('absen_teachers')
                    ->where('keterangan', 'hadir')
                    ->where('id_guru', $this->id_guru)
                    ->where('tanggal', 'like', '%'.date('Y-m',strtotime(now())).'%')
                    ->count(),
                    'bdr' => DB::table('absen_teachers')
                    ->where('keterangan', 'bdr')
                    ->where('id_guru', $this->id_guru)
                    ->where('tanggal', 'like', '%'.date('Y-m',strtotime(now())).'%')
                    ->count(),
                    'sakit' => DB::table('absen_teachers')
                    ->where('keterangan', 'sakit')
                    ->where('id_guru', $this->id_guru)
                    ->where('tanggal', 'like', '%'.date('Y-m',strtotime(now())).'%')
                    ->count(),
                    'izin' => DB::table('absen_teachers')
                    ->where('keterangan', 'izin')
                    ->where('id_guru', $this->id_guru)
                    ->where('tanggal', 'like', '%'.date('Y-m',strtotime(now())).'%')
                    ->count(),
                    'kegiatan' => DB::table('absen_teachers')
                    ->where('keterangan', 'kegiatan')
                    ->where('id_guru', $this->id_guru)
                    ->where('tanggal', 'like', '%'.date('Y-m',strtotime(now())).'%')
                    ->count(),
                    'nojadwal' => DB::table('absen_teachers')
                    ->where('id_guru', $this->id_guru)
                    ->where('tanggal', 'like', '%'.date('Y-m',strtotime(now())).'%')
                    ->where('keterangan', 'nojadwal')
                    ->count()
                ]);
            session()->flash('pesan','Berhasil Absen');
            $this->clearForm();
        }


    }
}
