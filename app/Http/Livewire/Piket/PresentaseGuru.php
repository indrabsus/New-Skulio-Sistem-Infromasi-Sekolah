<?php

namespace App\Http\Livewire\Piket;

use App\Models\TeacherCount;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class PresentaseGuru extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama_credit,$biaya_credit,$tahun_credit;
    public $result = 10;
    public $search = '';
    public function render()
    {
        return view('livewire.piket.presentase-guru',[
            'data' => DB::table('teacher_counts')
            ->leftJoin('teachers','teachers.id_guru','teacher_counts.id_guru')
            ->orderBy('id_hitung','desc')
            ->where('nama_guru', 'like', '%'.$this->search.'%')
            ->paginate($this->result),
            'max' => DB::table('teacher_counts')
            ->where('bulan')
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function clearForm(){
        $this->hadir = '';
        $this->total_absen = '';
    }
    public function edit($id){
        $user = DB::table('teacher_counts')->where('id_hitung', $id)->first();
        $this->hadir = $user->hadir;
        $this->total_absen = $user->total_absen;
        $this->ids = $user->id_hitung;
    }
    public function update(){
        $this->validate([
            'hadir' => 'required|numeric',
            'total_absen' => 'required|numeric'
        ]);
        TeacherCount::where('id_hitung',$this->ids)->update([
            'hadir' => $this->hadir,
            'total_absen' => $this->total_absen
        ]);
        session()->flash('pesan', 'Data berhasil diubah');
        $this->clearForm();
        $this->dispatchBrowserEvent('closeModal');
    }
}
