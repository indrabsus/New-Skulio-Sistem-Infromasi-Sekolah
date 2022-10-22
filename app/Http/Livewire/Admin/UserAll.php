<?php

namespace App\Http\Livewire\Admin;

use App\Models\Level;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class UserAll extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $level;
    public $result = 10;
    public $search = '';
    public function render()
    {
        return view('livewire.admin.user-all',[
            'data' => User::where('level','!=','siswa')
            ->where('username', 'like', '%'.$this->search.'%')
            ->paginate($this->result),
            'datalevel' => DB::table('levels')->get()
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }

    public function ClearForm()
    {
        $this->username = '';
        $this->level = '';
        $this->confirmed = '';
    }
    public function create(){
        $this->validate([
            'level' => 'required|unique:levels'
        ]);
        Level::create(['level' => $this->level]);
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil Disimpan');
        $this->ClearForm();
    }

    public function edit($id) {
        $user = DB::table('users')
                    ->where('users.id',$id)
                    ->first();
        $this->username = $user->username;
        $this->level = $user->level;
        $this->ids = $user->id;
    }

    public function update() {
        $this->validate([
            'level' => 'required',
        ]);
        $user = DB::table('users')
                    ->where('users.id',$this->ids)
                    ->first();

        $isi = [
                    'level' => $this->level
                    ];
        $get = User::where('id',$user->id)->update($isi);
        session()->flash('pesan', 'Data Berhasil Diedit');
        $this->ClearForm();
        $this->emit('edit');
    }

    public function konfirmasiHapus($id)
    {
        $user = DB::table('users')
            ->where('id', $id)
            ->first();

        $this->ids = $user->id;
    }

    public function delete()
    {
            $user = User::where('id', $this->ids)->delete();

        session()->flash('pesan', 'Data Berhasil Dihapus');
        $this->ClearForm();
        $this->emit('delete');
    }

}
