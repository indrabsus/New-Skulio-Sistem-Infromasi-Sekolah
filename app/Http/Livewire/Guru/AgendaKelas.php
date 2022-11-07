<?php

namespace App\Http\Livewire\Guru;

use App\Models\TeacherAgenda;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AgendaKelas extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $materi,$kegiatan,$id_jadwal, $created_at;
    public $result = 10;
    public $carihari = '';
    public $search = '';
    public function render()
    {
        $user = DB::table('users')->leftJoin('teachers','teachers.id_user','users.id')->where('id_user', Auth::user()->id)->first();
        return view('livewire.guru.agenda-kelas',[
            'data' => DB::table('schedules')
                    ->leftJoin('student_groups','student_groups.id_ajar','schedules.id_ajar')
                    ->leftJoin('guru_mapel_links','guru_mapel_links.id_gurumapel','student_groups.id_gurumapel')
                    ->leftJoin('teachers','teachers.id_guru','guru_mapel_links.id_guru')
                    ->leftJoin('subjects','subjects.id_mapel','guru_mapel_links.id_mapel')
                    ->leftJoin('groups','groups.id_kelas','student_groups.id_kelas')
                    ->where('guru_mapel_links.id_guru', $user->id_guru)
                    ->where('nama_mapel', 'like', '%'.$this->search.'%')
                    ->where('hari', 'like', '%'.$this->carihari.'%')
                   ->paginate($this->result),
            'agenda' =>DB::table('teacher_agendas')
            ->leftJoin('schedules','schedules.id_jadwal','teacher_agendas.id_jadwal')
            ->leftJoin('student_groups','student_groups.id_ajar','schedules.id_ajar')
            ->leftJoin('guru_mapel_links','guru_mapel_links.id_gurumapel','student_groups.id_gurumapel')
            ->leftJoin('teachers','teachers.id_guru','guru_mapel_links.id_guru')
            ->leftJoin('subjects','subjects.id_mapel','guru_mapel_links.id_mapel')
            ->leftJoin('groups','groups.id_kelas','student_groups.id_kelas')
            ->orderBy('id_agenda', 'desc')
            ->where('guru_mapel_links.id_guru', $user->id_guru)
            ->paginate(1),
            'guru' => DB::table('student_groups')
            ->leftJoin('groups','groups.id_kelas','student_groups.id_kelas')
            ->leftJoin('guru_mapel_links','guru_mapel_links.id_gurumapel','student_groups.id_gurumapel')
            ->leftJoin('teachers','teachers.id_guru','guru_mapel_links.id_guru')
            ->leftJoin('subjects','subjects.id_mapel','guru_mapel_links.id_mapel')
            ->get(),

        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function ClearForm()
    {
        $this->materi = '';
        $this->kegiatan = '';
    }
    public function agenda($id){
        $this->ids = $id;
    }
    public function kirimagenda(){

        $hitung = DB::table('teacher_agendas')
        ->where('id_jadwal', $this->ids)
        ->where('created_at', 'like', '%'.date('Y-m-d', strtotime(now())).'%')
        ->count();

        $this->validate([
            'materi' => 'required',
            'kegiatan' => 'required',
        ]);

        $isi = [
            'materi' => $this->materi,
            'kegiatan' => $this->kegiatan,
            'id_jadwal' => $this->ids
        ];
        if($hitung > 0){
            $this->dispatchBrowserEvent('closeModal');
        session()->flash('error', 'Anda Sudah isi agenda');
        $this->ClearForm();
        } else {
            $user = TeacherAgenda::create($isi);
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil Disimpan');
        $this->ClearForm();
        }
    }

}
