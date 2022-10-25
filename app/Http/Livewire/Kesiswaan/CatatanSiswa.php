<?php

namespace App\Http\Livewire\Kesiswaan;

use App\Models\Student;
use App\Models\StudentNote;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CatatanSiswa extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $keterangan, $tanggal;
    public $result = 10;
    public $search = '';
    public $cari_tahun = '';
    public function render()
    {
        return view('livewire.kesiswaan.catatan-siswa',[
            'data' => DB::table('student_notes')
                        ->leftJoin('students','students.id_siswa','student_notes.id_siswa')
                        ->leftJoin('groups','groups.id_kelas','student_notes.id_kelas')
                        ->where('nama_siswa', 'like', '%'.$this->search.'%')
                        ->paginate($this->result)
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function clearForm (){
        $this->keterangan = '';
        $this->tanggal = '';
    }
    public function edit($id){
        $user = DB::table('student_notes')->where('id_catatan', $id)->first();
        $this->keterangan = $user->keterangan;
        $this->tanggal = $user->tanggal;
        $this->ids = $user->id_catatan;
    }
    public function update(){
        $this->validate([
            'keterangan' => 'required',
            'tanggal' => 'required'
        ]);
        StudentNote::where('id_catatan', $this->ids)->update([
            'keterangan' => $this->keterangan,
            'tanggal' => $this->tanggal
        ]);
        session()->flash('pesan','Data berhasil diedit');
        $this->clearForm();
        $this->dispatchBrowserEvent('closeModal');
    }
    public function konfirmasiHapus($id){
        $user = DB::table('student_notes')->where('id_catatan', $id)->first();
        $this->kelakuan = $user->kelakuan;
        $this->kpoin = $user->kpoin;
        $this->ids = $user->id_catatan;
        $this->id_siswa = $user->id_siswa;
    }
    public function delete(){
        $siswa = DB::table('students')->where('id_siswa', $this->id_siswa)->first();
        if($this->kelakuan == 'baik'){
            Student::where('id_siswa', $this->id_siswa)->update(['poin' => $siswa->poin - $this->kpoin]);
        } else {
            Student::where('id_siswa', $this->id_siswa)->update(['poin' => $siswa->poin + $this->kpoin]);
        }
        StudentNote::where('id_catatan', $this->ids)->delete();
        session()->flash('pesan','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatchBrowserEvent('closeModal');
    }
}
