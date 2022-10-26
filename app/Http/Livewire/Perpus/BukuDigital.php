<?php

namespace App\Http\Livewire\Perpus;

use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class BukuDigital extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $judul_buku,$link_buku;
    public $result = 10;
    public $search = '';
    public function render()
    {
        return view('livewire.perpus.buku-digital',[
            'data' => DB::table('books')
            ->orderBy('id_buku','desc')
            ->where('judul_buku', 'like', '%'.$this->search.'%')
            ->paginate($this->result)
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function clearForm(){
        $this->judul_buku = '';
        $this->link_buku = '';
    }
    public function create(){
        $this->validate([
            'judul_buku' => 'required',
            'link_buku' => 'required'
        ]);
        Book::create([
            'judul_buku' => $this->judul_buku,
            'link_buku' => $this->link_buku,
            'pengirim' => Auth::user()->level
        ]);
        session()->flash('pesan','Data berhasil ditambahkan');
        $this->clearForm();
        $this->dispatchBrowserEvent('closeModal');
    }
    public function edit($id){
        $user = DB::table('books')->where('id_buku', $id)->first();
        $this->judul_buku = $user->judul_buku;
        $this->link_buku = $user->link_buku;
        $this->ids = $user->id_buku;
    }
    public function update(){
        $this->validate([
            'judul_buku' => 'required',
            'link_buku' => 'required'
        ]);
        Book::where('id_buku', $this->ids)->update([
            'judul_buku' => $this->judul_buku,
            'link_buku' => $this->link_buku,
        ]);
        session()->flash('pesan','Data berhasil diedit');
        $this->clearForm();
        $this->dispatchBrowserEvent('closeModal');
    }
    public function konfirmasiHapus($id){
        $user = DB::table('books')->where('id_buku', $id)->first();
        $this->ids = $user->id_buku;
    }
    public function delete(){
        Book::where('id_buku', $this->ids)->delete();
        session()->flash('pesan','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatchBrowserEvent('closeModal');
    }
}
