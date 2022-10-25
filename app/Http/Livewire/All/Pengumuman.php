<?php

namespace App\Http\Livewire\All;

use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Pengumuman extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama_kegiatan,$waktu_kegiatan,$tempat_kegiatan;
    public $result = 10;
    public $search = '';
    public function render()
    {
        return view('livewire.all.pengumuman',[
            'data' => DB::table('announcements')
            ->orderBy('id_kegiatan','desc')
            ->where('nama_kegiatan', 'like', '%'.$this->search.'%')
            ->paginate($this->result)
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function clearForm(){
        $this->nama_kegiatan = '';
        $this->tempat_kegiatan = '';
        $this->waktu_kegiatan = '';

    }
    public function create(){
        $this->validate([
            'nama_kegiatan' => 'required',
            'waktu_kegiatan' => 'required',
            'tempat_kegiatan' => 'required'
        ]);
        Announcement::create([
            'nama_kegiatan' => $this->nama_kegiatan,
            'waktu_kegiatan' => $this->waktu_kegiatan,
            'tempat_kegiatan' => $this->tempat_kegiatan,
            'pengirim' => Auth::user()->level
        ]);
        session()->flash('pesan', 'Data berhasil ditambahkan');
        $this->dispatchBrowserEvent('closeModal');
        $this->clearForm();
    }
    public function edit($id){
        $user = DB::table('announcements')->where('id_kegiatan', $id)->first();
        $this->nama_kegiatan = $user->nama_kegiatan;
        $this->tempat_kegiatan = $user->tempat_kegiatan;
        $this->waktu_kegiatan = $user->waktu_kegiatan;
        $this->ids = $user->id_kegiatan;
    }
    public function update(){
        $this->validate([
            'nama_kegiatan' => 'required',
            'waktu_kegiatan' => 'required',
            'tempat_kegiatan' => 'required'
        ]);
        Announcement::where('id_kegiatan', $this->ids)->update([
            'nama_kegiatan' => $this->nama_kegiatan,
            'waktu_kegiatan' => $this->waktu_kegiatan,
            'tempat_kegiatan' => $this->tempat_kegiatan,
            'pengirim' => Auth::user()->level
        ]);
        session()->flash('pesan', 'Data berhasil diedit');
        $this->dispatchBrowserEvent('closeModal');
        $this->clearForm();
    }
    public function konfirmasiHapus($id){
        $user = DB::table('announcements')->where('id_kegiatan', $id)->first();
        $this->ids = $user->id_kegiatan;
    }
    public function delete(){
        Announcement::where('id_kegiatan', $this->ids)->delete();
        session()->flash('pesan', 'Data berhasil dihapus');
        $this->dispatchBrowserEvent('closeModal');
        $this->clearForm();
    }
}
