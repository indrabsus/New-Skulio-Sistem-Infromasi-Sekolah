<?php

namespace App\Http\Livewire\Siswa;

use App\Models\TaskSubmit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Tugasku extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $jawaban,$nama_tugas,$deskripsi;
    public $result = 10;
    public $search = '';
    public function render()
    {
        $user = DB::table('users')
        ->leftJoin('students','students.id_user','users.id')
        ->where('id',Auth::user()->id)
        ->first();
        $this->id_kelas = $user->id_kelas;
        $this->id_siswa = $user->id_siswa;
        $data = DB::table('tasks')
            ->leftJoin('student_groups','student_groups.id_ajar','tasks.id_ajar')
            ->leftJoin('guru_mapel_links','guru_mapel_links.id_gurumapel','student_groups.id_gurumapel')
            ->leftJoin('teachers','teachers.id_guru','guru_mapel_links.id_guru')
            ->leftJoin('subjects','subjects.id_mapel','guru_mapel_links.id_mapel')
            ->leftJoin('task_submits','task_submits.id_tugas','tasks.id_tugas')
            ->where('student_groups.id_kelas',$this->id_kelas)
            ->where('nama_mapel', 'like', '%'.$this->search.'%')
            ->select('tasks.nama_tugas','subjects.nama_mapel','teachers.nama_guru','tasks.akhir', 'task_submits.jawaban','tasks.id_tugas')
            ->paginate($this->result);

        return view('livewire.siswa.tugasku',[
            'data' => $data,
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function clearForm(){
        $this->jawaban = '';
    }
    public function tugas($id){
        $user = DB::table('tasks')
        ->where('id_tugas', $id)
        ->first();
        $this->deskripsi = $user->deskripsi;
        $this->nama_tugas = $user->nama_tugas;
        $this->id_tugas = $user->id_tugas;
    }
    public function kirimTugas(){
        $this->validate([
            'jawaban' => 'required'
        ]);
        $hitung = DB::table('task_submits')
        ->where('id_tugas', $this->id_tugas)
        ->where('id_siswa', $this->id_siswa)
        ->count();
        if($hitung > 0) {
            session()->flash('pesan', 'Gagal kirim tugas, anda sudah submit');
            $this->clearForm();
            $this->dispatchBrowserEvent('closeModal');
        } else {
            TaskSubmit::create([
                'jawaban' => $this->jawaban,
                'id_siswa' => $this->id_siswa,
                'id_tugas' => $this->id_tugas
            ]);
            $this->clearForm();
            session()->flash('pesan', 'Tugas berhasil dikirim ke Guru');
            $this->dispatchBrowserEvent('closeModal');
        }

    }
}
