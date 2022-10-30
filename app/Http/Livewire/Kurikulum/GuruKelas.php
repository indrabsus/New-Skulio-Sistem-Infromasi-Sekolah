<?php

namespace App\Http\Livewire\Kurikulum;

use App\Models\Group;
use App\Models\StudentGroup;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class GuruKelas extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $id_gurumapel,$id_kelas;
    public $search = '';
    public $result = 10;
    public function render()
    {
        return view('livewire.kurikulum.guru-kelas',[
            'data' => DB::table('student_groups')
            ->leftJoin('guru_mapel_links','guru_mapel_links.id_gurumapel','student_groups.id_gurumapel')
            ->leftJoin('groups','groups.id_kelas','student_groups.id_kelas')
            ->leftJoin('teachers','teachers.id_guru','guru_mapel_links.id_guru')
            ->leftJoin('subjects','subjects.id_mapel','guru_mapel_links.id_mapel')
            ->orderBy('id_ajar','desc')
            ->where('nama_guru', 'like', '%'.$this->search.'%')
            ->paginate($this->result),
            'guru' => DB::table('guru_mapel_links')
            ->leftJoin('teachers','teachers.id_guru','guru_mapel_links.id_guru')
            ->leftJoin('subjects','subjects.id_mapel','guru_mapel_links.id_mapel')
            ->get(),
            'kelas' => Group::all()
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function clearForm(){
        $this->id_gurumapel = '';
        $this->id_kelas = '';
    }
    public function create(){
        $this->validate([
            'id_gurumapel' => 'required',
            'id_kelas' => 'required'
        ]);
        if(DB::table('student_groups')->where('id_gurumapel',$this->id_gurumapel)->where('id_kelas',$this->id_kelas)->count() > 0){
            session()->flash('pesan','Terdeteksi data ganda');
            $this->dispatchBrowserEvent('closeModal');
        } else {
            StudentGroup::create([
                'id_gurumapel' => $this->id_gurumapel,
                'id_kelas' => $this->id_kelas
            ]);
            $this->clearForm();
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan','Data berhasil ditambahkan');
        }

    }
    public function edit($id){
        $user = DB::table('student_groups')->where('id_ajar',$id)->first();
        $this->id_gurumapel = $user->id_gurumapel;
        $this->id_kelas = $user->id_kelas;
        $this->ids = $user->id_ajar;
    }
    public function update(){
        $this->validate([
            'id_gurumapel' => 'required',
            'id_kelas' => 'required'
        ]);
        if(DB::table('student_groups')->where('id_gurumapel',$this->id_gurumapel)->where('id_kelas',$this->id_kelas)->count() > 0){
            session()->flash('pesan','Terdeteksi data ganda');
            $this->dispatchBrowserEvent('closeModal');
        } else {
            StudentGroup::where('id_ajar', $this->ids)->update([
                'id_gurumapel' => $this->id_gurumapel,
                'id_kelas' => $this->id_kelas
            ]);
            $this->clearForm();
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan','Data berhasil ditambahkan');
        }
    }
    public function konfirmasiHapus($id){
        $user = DB::table('student_groups')->where('id_ajar',$id)->first();
        $this->ids = $user->id_ajar;
        }
    public function delete(){
        StudentGroup::where('id_ajar',$this->ids)->delete();
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan','Data berhasil ditambahkan');
    }
}
