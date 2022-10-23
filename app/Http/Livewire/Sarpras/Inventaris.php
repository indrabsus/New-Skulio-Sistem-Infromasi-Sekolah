<?php

namespace App\Http\Livewire\Sarpras;

use App\Models\Inventaris as ModelsInventaris;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Inventaris extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama_barang,$jumlah_barang,$tempat_barang,$sumber_barang,$keterangan,$tanggal;
    public $result = 10;
    public $search = '';
    public function render()
    {
        return view('livewire.sarpras.inventaris',[
            'data' => DB::table('inventaris')
            ->where('nama_barang', 'like', '%'.$this->search.'%')
            ->orderBy('id_barang', 'desc')
            ->paginate($this->result)
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function clearForm(){
        $this->nama_barang = '';
        $this->jumlah_barang = '';
        $this->tempat_barang = '';
        $this->sumber_barang = '';
        $this->keterangan = '';
        $this->tanggal = '';
    }
    public function create(){
        $this->validate([
            'nama_barang' => 'required',
            'jumlah_barang' => 'required|numeric',
            'tempat_barang' => 'required',
            'sumber_barang' => 'required',
            'keterangan' => 'required',
            'tanggal' => 'required',
        ]);
        ModelsInventaris::create([
            'nama_barang' => $this->nama_barang,
            'jumlah_barang' => $this->jumlah_barang,
            'tempat_barang' => $this->tempat_barang,
            'sumber_barang' =>  $this->sumber_barang,
            'keterangan' => $this->keterangan,
            'tanggal' => $this->tanggal,
        ]);
        session()->flash('pesan','Data berhasil ditambahkan');
        $this->dispatchBrowserEvent('closeModal');
        $this->clearForm();
    }
    public function edit($id){
        $user = DB::table('inventaris')->where('id_barang', $id)->first();
        $this->nama_barang = $user->nama_barang;
        $this->jumlah_barang = $user->jumlah_barang;
        $this->tempat_barang = $user->tempat_barang;
        $this->sumber_barang = $user->sumber_barang;
        $this->keterangan = $user->keterangan;
        $this->tanggal = $user->tanggal;
        $this->ids = $user->id_barang;
    }
    public function update(){
        $this->validate([
            'nama_barang' => 'required',
            'jumlah_barang' => 'required|numeric',
            'tempat_barang' => 'required',
            'sumber_barang' => 'required',
            'keterangan' => 'required',
            'tanggal' => 'required',
        ]);
        ModelsInventaris::where('id_barang', $this->ids)->update([
            'nama_barang' => $this->nama_barang,
            'jumlah_barang' => $this->jumlah_barang,
            'tempat_barang' => $this->tempat_barang,
            'sumber_barang' =>  $this->sumber_barang,
            'keterangan' => $this->keterangan,
            'tanggal' => $this->tanggal,
        ]);
        session()->flash('pesan','Data berhasil diedit');
        $this->dispatchBrowserEvent('closeModal');
        $this->clearForm();
    }
    public function konfirmasiHapus($id){
        $user = DB::table('inventaris')->where('id_barang', $id)->first();
        $this->ids = $user->id_barang;
    }
    public function delete(){
        ModelsInventaris::where('id_barang',$this->ids)->delete();
        session()->flash('pesan','Data berhasil dihapus');
        $this->dispatchBrowserEvent('closeModal');
        $this->clearForm();
    }
}
