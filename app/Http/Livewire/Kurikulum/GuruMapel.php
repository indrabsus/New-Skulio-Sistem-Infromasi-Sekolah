<?php

namespace App\Http\Livewire\Kurikulum;

use App\Models\GuruMapelLink;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class GuruMapel extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $id_guru,$id_mapel;
    public $result = 10;
    public $search = '';
    public function render()
    {
        return view('livewire.kurikulum.guru-mapel',[
            'data' => DB::table('guru_mapel_links')
            ->leftJoin('teachers','teachers.id_guru','guru_mapel_links.id_guru')
            ->leftJoin('subjects','subjects.id_mapel','guru_mapel_links.id_mapel')
            ->orderBy('id_gurumapel','desc')
            ->where('nama_mapel', 'like', '%'.$this->search.'%')
            ->paginate($this->result),

            'guru' => Teacher::all(),
            'mapel' => Subject::all()
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function ClearForm()
    {
        $this->id_mapel = '';
        $this->id_guru = '';
    }
    public function create(){
        $hitungGuru = DB::table('guru_mapel_links')
        ->where('id_guru',$this->id_guru)
        ->where('id_mapel',$this->id_mapel)
        ->count();
        if( $hitungGuru == 1){

            session()->flash('pesan','Peringatan data sudah ada');
            $this->ClearForm();
            $this->dispatchBrowserEvent('closeModal');
        }
        $this->validate([
            'id_guru' => 'required',
            'id_mapel' => 'required',
        ]);

        $isi = [
            'id_guru' => $this->id_guru,
            'id_mapel' => $this->id_mapel,
        ];

        $user = GuruMapelLink::create($isi);

        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil Disimpan');
        $this->ClearForm();
    }
    public function edit($id) {
        $user = DB::table('guru_mapel_links')
                ->leftJoin('teachers','teachers.id_guru','guru_mapel_links.id_guru')
                ->leftJoin('subjects','subjects.id_mapel','guru_mapel_links.id_mapel')
                ->where('id_gurumapel',$id)
                ->first();
        $this->id_mapel = $user->id_mapel;
        $this->id_guru = $user->id_guru;
        $this->id_gurumapel = $user->id_gurumapel;
    }
    public function update() {
        $hitungGuru = DB::table('guru_mapel_links')
        ->where('id_guru',$this->id_guru)
        ->where('id_mapel',$this->id_mapel)
        ->count();
        if( $hitungGuru == 1){

            session()->flash('pesan','Peringatan data sudah ada');
            $this->ClearForm();
            $this->dispatchBrowserEvent('closeModal');
        }
        $this->validate([
            'id_guru' => 'required',
            'id_mapel' => 'required',
        ]);

        GuruMapelLink::where('id_gurumapel',$this->id_gurumapel)->update([
            'id_mapel' => $this->id_mapel,
            'id_guru' => $this->id_guru,
        ]);

        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil Diedit');
        $this->ClearForm();
    }
    public function konfirmasiHapus($id)
    {
        $user = DB::table('guru_mapel_links')
            ->where('id_gurumapel', $id)
            ->first();

        $this->ids = $user->id_gurumapel;
    }

    public function delete()
    {
            $user = GuruMapelLink::where('id_gurumapel', $this->ids)->delete();

        session()->flash('pesan', 'Data Berhasil Dihapus');
        $this->dispatchBrowserEvent('closeModal');
        $this->ClearForm();
    }
}
