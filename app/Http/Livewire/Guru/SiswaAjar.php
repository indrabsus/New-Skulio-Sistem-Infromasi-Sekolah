<?php

namespace App\Http\Livewire\Guru;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class SiswaAjar extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $id_ajar,$id_kelas, $nama_tugas, $deskripsi,$akhir,$nama_kelas;
    public $result = 10;
    public $search = '';
    public $tugas= [];
    public function render()
    {
        $user = DB::table('users')
        ->leftJoin('teachers','teachers.id_user','users.id')
        ->where('id',Auth::user()->id)
        ->first();

        return view('livewire.guru.siswa-ajar',[
            'data' => DB::table('tasks')
            ->leftJoin('student_groups','student_groups.id_ajar','tasks.id_ajar')
            ->leftJoin('guru_mapel_links','guru_mapel_links.id_gurumapel','student_groups.id_gurumapel')
            ->leftJoin('subjects','subjects.id_mapel','guru_mapel_links.id_mapel')
            ->leftJoin('groups','groups.id_kelas','student_groups.id_kelas')
            ->where('guru_mapel_links.id_guru', $user->id_guru)
            ->paginate($this->result),
            'gurumapel' => DB::table('student_groups')
            ->leftJoin('guru_mapel_links','guru_mapel_links.id_gurumapel','student_groups.id_gurumapel')
            ->leftJoin('teachers','teachers.id_guru','guru_mapel_links.id_guru')
            ->leftJoin('subjects','subjects.id_mapel','guru_mapel_links.id_mapel')
            ->leftJoin('groups','groups.id_kelas','student_groups.id_kelas')
            ->where('guru_mapel_links.id_guru', $user->id_guru)
            ->orderBy('id_ajar','desc')
            ->where('nama_kelas', 'like', '%'.$this->search.'%')
            ->get()

        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function clearForm(){
        $this->nama_tugas = '';
        $this->deskripsi = '';
        $this->akhir = '';
    }

    public function kirim(){

        $this->validate([
            'nama_tugas' => 'required',
            'deskripsi' => 'required',
            'akhir' => 'required',
            'tugas' => 'required'
        ]);

        for($no=0; $no < count($this->tugas); $no++){
            Task::create([
                'nama_tugas' => $this->nama_tugas,
                'deskripsi' => $this->deskripsi,
                'akhir' => $this->akhir,
                'id_ajar' => $this->tugas[$no]
            ]);
        }
        $this->clearForm();
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Tugas berhasil dikirim');
    }
    public function edit($id){
        $user = DB::table('tasks')
        ->where('id_tugas',  $id)->first();
        $this->nama_tugas = $user->nama_tugas;
        $this->deskripsi = $user->deskripsi;
        $this->akhir = $user->akhir;
        $this->ids = $user->id_tugas;
    }
    public function update(){
        $this->validate([
            'nama_tugas' => 'required',
            'deskripsi' => 'required',
            'akhir' => 'required'
        ]);
            Task::where('id_tugas', $this->ids)->update([
                'nama_tugas' => $this->nama_tugas,
                'deskripsi' => $this->deskripsi,
                'akhir' => $this->akhir,
            ]);
        $this->clearForm();
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Tugas berhasil dikirim');
    }
    public function konfirmasiHapus($id){
        $user = DB::table('tasks')->where('id_tugas', $id)->first();
        $this->ids = $user->id_tugas;
    }
    public function delete(){
        Task::where('id_tugas',$this->ids)->delete();
        session()->flash('pesan', 'Data Berhasil dihapus');
        $this->dispatchBrowserEvent('closeModal');
        $this->ClearForm();
    }
}
