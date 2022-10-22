<?php

namespace App\Http\Livewire\Kurikulum;

use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class MapelMgmt extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama_mapel;
    public $result = 10;
    public $search = '';
    public function render()
    {
        return view('livewire.kurikulum.mapel-mgmt',[
            'data' => Subject::orderBy('id_mapel')
            ->where('nama_mapel', 'like', '%'.$this->search.'%')
            ->paginate($this->result),
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function ClearForm()
    {
        $this->nama_mapel = '';
    }
    public function create(){
        $this->validate([
            'nama_mapel' => 'required|unique:subjects',
        ]);
        $isi = [
            'nama_mapel' => $this->nama_mapel,
        ];

        $user = Subject::create($isi);

        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil Disimpan');
        $this->ClearForm();
    }
    public function edit($id) {
        $user = DB::table('subjects')
                    ->where('id_mapel',$id)
                    ->first();
        $this->id_mapel = $user->id_mapel;
        $this->nama_mapel = $user->nama_mapel;
    }
    public function update() {
        $this->validate([
            'nama_mapel' => 'required|unique:subjects',
        ]);

        Subject::where('id_mapel',$this->id_mapel)->update([
            'nama_mapel' => $this->nama_mapel
        ]);

        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil Diedit');
        $this->ClearForm();
    }
    public function konfirmasiHapus($id)
    {
        $user = DB::table('subjects')
            ->where('id_mapel', $id)
            ->first();

        $this->ids = $user->id_mapel;
    }

    public function delete()
    {
            $user = Subject::where('id_mapel', $this->ids)->delete();

        session()->flash('pesan', 'Data Berhasil Dihapus');
        $this->dispatchBrowserEvent('closeModal');
        $this->ClearForm();
    }
}
