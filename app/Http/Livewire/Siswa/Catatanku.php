<?php

namespace App\Http\Livewire\Siswa;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Catatanku extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $poin;
    public $result = 10;
    public $search = '';
    public function render()
    {
        if(Auth::user()->level == 'student'){
            $user = DB::table('students')
        ->where('id_user', Auth::user()->id)
        ->first();
        $this->poin = $user->poin;
        } else {
            $this->poin = '';
        }
        return view('livewire.siswa.catatanku',[
            'data' => DB::table('student_notes')
            ->leftJoin('students','students.id_siswa','student_notes.id_siswa')
            ->where('id_user', Auth::user()->id)
            ->where('keterangan', 'like', '%'.$this->search.'%')
            ->paginate($this->result),
            'poin' => $this->poin
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
}
