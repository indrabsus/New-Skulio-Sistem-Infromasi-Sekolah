<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    public $password;
    public function render()
    {
        return view('livewire.admin.index',[
            'teachers' => DB::table('users')
                            ->where('level','guru')
                            ->count(),
            'students' => DB::table('users')
                            ->where('level','siswa')
                            ->where('confirmed','y')
                            ->count(),
            'groups' => DB::table('groups')
                            ->count(),
            'subjects' => DB::table('subjects')
                            ->count(),
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function ubah($id){
        $data = DB::table('users')
                ->where('id', Auth::user()->id)
                ->first();
        $this->ids = $data->id;
    }
    public function ganti(){
        $this->validate([
            'password' => 'required'
        ]);
        $isi = [
            'password' => bcrypt($this->password)
        ];
        User::where('id', $this->ids)->update($isi);
        session()->flash('pesan', 'password berhasil diubah');
        return redirect()->route('index');
    }
}
