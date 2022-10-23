<?php

namespace App\Http\Livewire\Admin;

use App\Models\Menu;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class MenuMgmt extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama_menu,$path,$class,$route,$level;
    public $result = 10;
    public $search = '';
    public function render()
    {
        return view('livewire.admin.menu-mgmt',[
            'data' => DB::table('menus')
            ->orderBy('id_menu','desc')
            ->where('nama_menu', 'like', '%'.$this->search.'%')
            ->paginate($this->result),
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function ClearForm()
    {
        $this->nama_menu = '';
        $this->path = '';
        $this->class = '';
        $this->route = '';
        $this->level = '';
    }
    public function create(){
        $this->validate([
            'nama_menu' => 'required',
            'path' => 'required',
            'class' => 'required',
            'route' => 'required',
            'level' => 'required',
        ]);

        $isi = [
            'nama_menu' => $this->nama_menu,
            'path' => $this->path,
            'class' => $this->class,
            'route' => $this->route,
            'level' => $this->level,
        ];

        $user = Menu::create($isi);

        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil Disimpan');
        $this->ClearForm();
    }
    public function edit($id){
        $menu = DB::table('menus')->where('id_menu', $id)->first();
        $this->nama_menu = $menu->nama_menu;
        $this->path = $menu->path;
        $this->class = $menu->class;
        $this->route = $menu->route;
        $this->level = $menu->level;
        $this->ids = $menu->id_menu;
    }
    public function update(){
        $this->validate([
            'nama_menu' => 'required',
            'path' => 'required',
            'class' => 'required',
            'route' => 'required',
            'level' => 'required',
        ]);

        $isi = [
            'nama_menu' => $this->nama_menu,
            'path' => $this->path,
            'class' => $this->class,
            'route' => $this->route,
            'level' => $this->level,
        ];

        $user = Menu::where('id_menu', $this->ids)->update($isi);

        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil diedit');
        $this->ClearForm();
    }
    public function konfirmasiHapus($id)
    {
        $user = DB::table('menus')
            ->where('id_menu', $id)
            ->first();

        $this->ids = $user->id_menu;
    }

    public function delete()
    {
            $user = Menu::where('id_menu', $this->ids)->delete();

        session()->flash('pesan', 'Data Berhasil Dihapus');
        $this->dispatchBrowserEvent('closeModal');
        $this->ClearForm();
    }

}
