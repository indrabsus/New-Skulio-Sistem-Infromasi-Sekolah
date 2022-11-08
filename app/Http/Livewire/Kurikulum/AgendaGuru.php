<?php

namespace App\Http\Livewire\Kurikulum;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AgendaGuru extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama_credit,$biaya_credit,$tahun_credit;
    public $result = 10;
    public $search = '';
    public $caritanggal = '';
    public function render()
    {
        return view('livewire.kurikulum.agenda-guru',[
            'data' => DB::table('teacher_agendas')
            ->leftJoin('schedules','schedules.id_jadwal','teacher_agendas.id_jadwal')
            ->leftJoin('student_groups','student_groups.id_ajar','schedules.id_ajar')
            ->leftJoin('guru_mapel_links','guru_mapel_links.id_gurumapel','student_groups.id_gurumapel')
            ->leftJoin('teachers','teachers.id_guru','guru_mapel_links.id_guru')
            ->leftJoin('subjects','subjects.id_mapel','guru_mapel_links.id_mapel')
            ->leftJoin('groups','groups.id_kelas','student_groups.id_kelas')
            ->orderBy('id_agenda', 'desc')
            ->select('teacher_agendas.created_at','teachers.nama_guru','subjects.nama_mapel','teacher_agendas.materi','teacher_agendas.kegiatan','groups.nama_kelas')
            ->where('nama_guru', 'like', '%'.$this->search.'%')
            ->where('teacher_agendas.created_at', 'like', '%'.$this->caritanggal.'%')
            ->paginate($this->result),
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
}
