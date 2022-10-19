<?php

namespace App\Http\Livewire\Kurikulum;

use App\Models\Group;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class KelasMgmt extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $id_guru, $nama_kelas, $id_kelas;
    public $result = 10;
    public $search = '';
    public function render()
    {
        return view('livewire.kurikulum.kelas-mgmt',[
            'data' => DB::table('groups')
                    ->leftJoin('teachers','teachers.id_guru','groups.id_guru')
                    ->orderBy('id_kelas','desc')
                    ->where('nama_kelas', 'like', '%'.$this->search.'%')
                    ->paginate($this->result),
            'kelas' => Group::all(),
            'guru' => Teacher::all()
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function ClearForm()
    {
        $this->id_guru = '';
        $this->nama_kelas = '';
    }
    public function create(){
        $this->validate([
            'nama_kelas' => 'required|unique:groups',
        ]);
        $isi = [
            'nama_kelas' => $this->nama_kelas,
        ];

        $user = Group::create($isi);

        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil Disimpan');
        $this->ClearForm();
    }

    public function edit($id) {
        $user = DB::table('groups')
                    ->leftJoin('teachers','teachers.id_guru','groups.id_guru')
                    ->where('groups.id_kelas',$id)
                    ->first();
        $this->id_kelas = $user->id_kelas;
        $this->id_guru = $user->id_guru;
        $this->nama_guru = $user->nama_guru;
        $this->nama_kelas = $user->nama_kelas;
    }

    public function update() {
        $this->validate([
            'id_guru' => 'required',
        ]);

        Group::where('id_kelas',$this->id_kelas)->update([
            'id_guru' => $this->id_guru
        ]);

        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil Diedit');
        $this->ClearForm();
    }
    public function konfirmasiHapus($id)
    {
        $user = DB::table('groups')
            ->where('id_kelas', $id)
            ->first();

        $this->ids = $user->id_kelas;
    }

    public function delete()
    {
            $user = Group::where('id_kelas', $this->ids)->delete();

        session()->flash('pesan', 'Data Berhasil Dihapus');
        $this->dispatchBrowserEvent('closeModal');
        $this->ClearForm();
    }

}
