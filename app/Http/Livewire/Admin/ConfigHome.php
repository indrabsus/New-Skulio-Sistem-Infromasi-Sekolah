<?php

namespace App\Http\Livewire\Admin;

use App\Models\galery;
use App\Models\Jurusan;
use App\Models\Slider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ConfigHome extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    public $gambar,$judul,$deskripsi,$link,$ids, $tombol;
    public $result = 5;
    public $gal = 5;
    public $search = '';
    public function render()
    {
        return view('livewire.admin.config-home',[
            'data' => DB::table('sliders')
            ->orderBy('id_slider','desc')
            ->paginate($this->result),
            'galery' => DB::table('galeries')
            ->orderBy('id_galeri', 'desc')
            ->paginate($this->gal),
            'jurusan' => DB::table('jurusans')
            ->get()
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function ClearForm()
    {
        $this->gambar = '';
        $this->judul = '';
        $this->deskripsi = '';
        $this->link = '';
        $this->tombol = '';
    }
    public function create(){
        $this->validate([
            'gambar' => 'required|image|max:2048',
        ]);

        $ext = $this->gambar->extension();
        $path = $this->gambar->storeAs('public/slider', strtotime(now()).'slider.'.$ext);
        
        $isi = [
            'gambar' => $path,
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'link' => $this->link,
            'tombol' => $this->tombol
        ];

        $user = Slider::create($isi);

        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil Disimpan');
        $this->ClearForm();
    }
    public function edit($id){
        $menu = DB::table('sliders')->where('id_slider', $id)->first();
        $this->gambar = $menu->gambar;
        $this->judul = $menu->judul;
        $this->deskripsi = $menu->deskripsi;
        $this->link = $menu->link;
        $this->ids = $menu->id_slider;
        $this->tombol = $menu->tombol;
    }
    public function update(){
        $isi = [
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'link' => $this->link,
            'tombol' => $this->tombol
        ];

        $user = Slider::where('id_slider', $this->ids)->update($isi);

        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil diedit');
        $this->ClearForm();
    }
    public function konfirmasiHapus($id)
    {
        $user = DB::table('sliders')
            ->where('id_slider', $id)
            ->first();

        $this->ids = $user->id_slider;
        $this->gambar = $user->gambar;
    }

    public function delete()
    {
            $user = Slider::where('id_slider', $this->ids)->delete();
            $hapus = $this->gambar;
            Storage::delete($hapus);
            

        session()->flash('pesan', 'Data Berhasil Dihapus');
        $this->dispatchBrowserEvent('closeModal');
        $this->ClearForm();
    }


    public function create2(){
        $this->validate([
            'gambar' => 'required|image|max:2048',
            'judul' => 'required',
            'deskripsi' => 'required',
            'link' => 'required'
        ]);

        $ext = $this->gambar->extension();
        $path = $this->gambar->storeAs('public/galeri', strtotime(now()).'dokumentasi.'.$ext);
        
        $isi = [
            'gambar' => $path,
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'link' => $this->link,
        ];

        $user = galery::create($isi);

        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil Disimpan');
        $this->ClearForm();
    }
    public function edit2($id){
        $menu = DB::table('galeries')->where('id_galeri', $id)->first();
        $this->gambar = $menu->gambar;
        $this->judul = $menu->judul;
        $this->deskripsi = $menu->deskripsi;
        $this->link = $menu->link;
        $this->ids = $menu->id_galeri;
    }
    public function update2(){
        $this->validate([
            'gambar' => 'required|image|max:2048',
            'judul' => 'required',
            'deskripsi' => 'required',
            'link' => 'required'
        ]);
        $isi = [
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'link' => $this->link,
        ];

        $user = galery::where('id_galeri', $this->ids)->update($isi);

        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil diedit');
        $this->ClearForm();
    }
    public function konfirmasiHapus2($id)
    {
        $user = DB::table('galeries')
            ->where('id_galeri', $id)
            ->first();

        $this->ids = $user->id_galeri;
        $this->gambar = $user->gambar;
    }

    public function delete2()
    {
            $user = galery::where('id_galeri', $this->ids)->delete();
            $hapus = $this->gambar;
            Storage::delete($hapus);
            

        session()->flash('pesan', 'Data Berhasil Dihapus');
        $this->dispatchBrowserEvent('closeModal');
        $this->ClearForm();
    }

    public function create3(){
        $this->validate([
            'gambar' => 'required|image|max:2048',
            'deskripsi' => 'required',
        ]);

        $ext = $this->gambar->extension();
        $path = $this->gambar->storeAs('public/jurusan', strtotime(now()).'jurusan.'.$ext);
        
        $isi = [
            'gambar' => $path,
            'deskripsi' => $this->deskripsi,
        ];

        $user = Jurusan::create($isi);

        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil Disimpan');
        $this->ClearForm();
    }
    public function edit3($id){
        $menu = DB::table('jurusans')->where('id_jurusan', $id)->first();
        $this->gambar = $menu->gambar;
        $this->deskripsi = $menu->deskripsi;
        $this->ids = $menu->id_jurusan;
    }
    public function update3(){
        $this->validate([
            'gambar' => 'required|image|max:2048',
        ]);
        $isi = [
            'deskripsi' => $this->deskripsi,
        ];

        $user = Jurusan::where('id_jurusan', $this->ids)->update($isi);

        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil diedit');
        $this->ClearForm();
    }
    public function konfirmasiHapus3($id)
    {
        $user = DB::table('jurusans')
            ->where('id_jurusan', $id)
            ->first();

        $this->ids = $user->id_jurusan;
        $this->gambar = $user->gambar;
    }

    public function delete3()
    {
            $user = Jurusan::where('id_jurusan', $this->ids)->delete();
            $hapus = $this->gambar;
            Storage::delete($hapus);
            

        session()->flash('pesan', 'Data Berhasil Dihapus');
        $this->dispatchBrowserEvent('closeModal');
        $this->ClearForm();
    }

}
