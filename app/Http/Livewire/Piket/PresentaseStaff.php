<?php

namespace App\Http\Livewire\Piket;

use App\Models\StaffCount;
use App\Models\TeacherCount;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class PresentaseStaff extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama_credit,$biaya_credit,$tahun_credit;
    public $result = 10;
    public $search = '';
    public function render()
    {
        return view('livewire.piket.presentase-staff',[
            'data' => DB::table('staff_counts')
            ->leftJoin('stafs','stafs.id_staf','staff_counts.id_tendik')
            ->orderBy('id_hitung','desc')
            ->where('nama_staf', 'like', '%'.$this->search.'%')
            ->paginate($this->result),
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function clearForm(){
        $this->hadir = '';
        $this->total_absen = '';
    }
    public function edit($id){
        $user = DB::table('staff_counts')->where('id_hitung', $id)->first();
        $this->hadir = $user->hadir;
        $this->total_absen = $user->total_absen;
        $this->ids = $user->id_hitung;
    }
    public function update(){
        $this->validate([
            'hadir' => 'required|numeric',
            'total_absen' => 'required|numeric'
        ]);
        StaffCount::where('id_hitung',$this->ids)->update([
            'hadir' => $this->hadir,
            'total_absen' => $this->total_absen
        ]);
        session()->flash('pesan', 'Data berhasil diubah');
        $this->clearForm();
        $this->dispatchBrowserEvent('closeModal');
    }
}
