<?php

namespace App\Http\Livewire\Ppdb;

use App\Models\NewGroup;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Kelas extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama_kelas, $id_kelas;
    public $result = 10;
    public $search = '';
    public function render()
    {
        return view('livewire.ppdb.kelas',[
            'data' => DB::table('new_groups')
                    ->orderBy('id_kelas','desc')
                    ->where('nama_kelas', 'like', '%'.$this->search.'%')
                    ->paginate($this->result)
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function ClearForm()
    {
        $this->nama_kelas = '';
    }
    public function create(){
        $this->validate([
            'nama_kelas' => 'required|unique:new_groups',
        ]);
        $isi = [
            'nama_kelas' => $this->nama_kelas,
        ];

        $user = NewGroup::create($isi);

        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil Disimpan');
        $this->ClearForm();
    }

    public function edit($id) {
        $user = DB::table('new_groups')
                    ->where('id_kelas',$id)
                    ->first();
        $this->id_kelas = $user->id_kelas;
        $this->nama_kelas = $user->nama_kelas;
    }

    public function update() {
        $this->validate([
            'nama_kelas' => 'required',
        ]);

        NewGroup::where('id_kelas',$this->id_kelas)->update([
            'nama_kelas' => $this->nama_kelas
        ]);

        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil Diedit');
        $this->ClearForm();
    }
    public function konfirmasiHapus($id)
    {
        $user = DB::table('new_groups')
            ->where('id_kelas', $id)
            ->first();

        $this->id_kelas = $user->id_kelas;
    }

    public function delete()
    {
            $user = NewGroup::where('id_kelas', $this->id_kelas)->delete();

        session()->flash('pesan', 'Data Berhasil Dihapus');
        $this->dispatchBrowserEvent('closeModal');
        $this->ClearForm();
    }
}
