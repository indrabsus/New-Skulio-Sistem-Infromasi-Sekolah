<?php

namespace App\Http\Livewire\Guru;

use App\Models\TaskSubmit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class TugasSiswa extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nilai,$jawaban,$tahun_credit;
    public $result = 10;
    public $search = '';
    public function render()
    {
        $user = DB::table('users')
        ->leftJoin('teachers','teachers.id_user','users.id')
        ->where('id',Auth::user()->id)
        ->first();
        return view('livewire.guru.tugas-siswa',[
            'data' => DB::table('task_submits')
            ->leftJoin('tasks','tasks.id_tugas','task_submits.id_tugas')
            ->leftJoin('students','students.id_siswa','task_submits.id_siswa')
            ->leftJoin('student_groups','student_groups.id_ajar','tasks.id_ajar')
            ->leftJoin('guru_mapel_links','guru_mapel_links.id_gurumapel','student_groups.id_gurumapel')
            ->leftJoin('subjects','subjects.id_mapel','guru_mapel_links.id_mapel')
            ->leftJoin('groups','groups.id_kelas','student_groups.id_kelas')
            ->where('guru_mapel_links.id_guru', $user->id_guru)
            ->orderBy('id_submit','desc')
            ->where('nama_siswa', 'like', '%'.$this->search.'%')
            ->paginate($this->result)
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function clearForm(){
        $this->nilai = '';
    }
    public function nilai($id){
        $user = DB::table('task_submits')->where('id_submit',$id)->first();
        $this->nilai = $user->nilai;
        $this->jawaban = $user->jawaban;
        $this->ids = $user->id_submit;
    }
    public function berinilai(){
        $this->validate([
            'nilai' => 'required|numeric'
        ]);
        TaskSubmit::where('id_submit', $this->ids)->update([
            'nilai' => $this->nilai
        ]);
        $this->clearForm();
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Tugas berhasil dinilai');
    }
}
