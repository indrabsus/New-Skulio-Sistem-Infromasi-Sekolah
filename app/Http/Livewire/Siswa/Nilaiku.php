<?php

namespace App\Http\Livewire\Siswa;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Nilaiku extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nilai,$jawaban,$tahun_credit;
    public $result = 10;
    public $search = '';
    public function render()
    {
        $user = DB::table('users')
        ->leftJoin('students','students.id_user','users.id')
        ->where('id', Auth::user()->id)
        ->first();
        return view('livewire.siswa.nilaiku',[
            'data' => DB::table('task_submits')
            ->leftJoin('tasks','tasks.id_tugas','task_submits.id_tugas')
            ->leftJoin('student_groups','student_groups.id_ajar','tasks.id_ajar')
            ->leftJoin('guru_mapel_links','guru_mapel_links.id_gurumapel','student_groups.id_gurumapel')
            ->leftJoin('subjects','subjects.id_mapel','guru_mapel_links.id_mapel')
            ->where('id_siswa', $user->id_siswa)
            ->orderBy('id_submit','desc')
            ->where('nama_tugas', 'like', '%'.$this->search.'%')
            ->paginate($this->result)
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
}
