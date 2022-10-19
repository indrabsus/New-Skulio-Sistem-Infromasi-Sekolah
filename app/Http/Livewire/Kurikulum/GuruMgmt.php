<?php

namespace App\Http\Livewire\Kurikulum;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class GuruMgmt extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama_guru, $username, $jk_guru, $kode_guru, $nohp_guru;
    public $result = 10;
    public $search = '';
    public function render()
    {
        return view('livewire.kurikulum.guru-mgmt',[
            'data' => DB::table('teachers')
                    ->leftJoin('users','users.id','teachers.id_user')
                    ->orderBy('kode_guru','asc')
                    ->where('nama_guru', 'like', '%'.$this->search.'%')
                    ->paginate($this->result)
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function ClearForm()
    {
        $this->username = '';
        $this->nama_guru = '';
        $this->jk_guru = '';
        $this->nohp_guru = '';
        $this->kode_guru = '';
    }
    public function create(){
        $this->validate([
            'username' => 'required|unique:users|alpha|min:4',
            'jk_guru' => 'required',
            'nama_guru' => 'required',
            'nohp_guru' => 'required|numeric',
            'kode_guru' => 'required|numeric'
        ]);
        $isi = [
            'username' => strtolower($this->username),
            'password' => bcrypt('rahasia'),
            'level' => 'guru',
            'confirmed' => 'y'
        ];

        $user = User::create($isi);

        $isiGuru = [
            'nama_guru' => $this->nama_guru,
            'jk_guru' => $this->jk_guru,
            'nohp_guru' => $this->nohp_guru,
            'id_user' => $user->id,
            'kode_guru' => $this->kode_guru
        ];
        Teacher::create($isiGuru);
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil Disimpan');
        $this->ClearForm();
        // return redirect('operator/guru');
    }
    public function creset($id)
    {
        $user = DB::table('users')
            ->where('users.id', $id)
            ->first();

        $this->ids = $user->id;
    }
    public function resetpass()
    {
        $isi = [
            'password' => bcrypt('rahasia'),
        ];
        DB::table('users')->where('id', $this->ids)->update($isi);
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Password berhasil di reset');
        // return redirect()->route('gurumgmt');
    }
    public function edit($id) {
        $user = DB::table('teachers')
                    ->leftJoin('users', 'users.id', 'teachers.id_user')
                    ->where('users.id',$id)
                    ->first();
        $this->ids = $user->id;
        $this->id_guru = $user->id_guru;
        $this->nama_guru = $user->nama_guru;
        $this->username = $user->username;
        $this->jk_guru = $user->jk_guru;
        $this->nohp_guru = $user->nohp_guru;
        $this->kode_guru = $user->kode_guru;
    }

    public function update() {
        $this->validate([
            'jk_guru' => 'required',
            'nama_guru' => 'required',
            'nohp_guru' => 'required|numeric',
            'kode_guru' => 'required|numeric'
        ]);
        $isiGuru = [
                    'nama_guru' => $this->nama_guru,
                    'jk_guru' => $this->jk_guru,
                    'nohp_guru' => $this->nohp_guru,
                    'id_user' => $this->ids,
                    'kode_guru' => $this->kode_guru,
                    ];
        $get = Teacher::where('id_guru',$this->id_guru)->update($isiGuru);
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil Diedit');
        $this->ClearForm();
    }
    public function konfirmasiHapus($id)
    {
        $user = DB::table('users')
            ->where('id', $id)
            ->first();

        $this->ids = $user->id;
    }

    public function delete()
    {
            $user = User::where('id', $this->ids)->delete();

        session()->flash('pesan', 'Data Berhasil Dihapus');
        $this->dispatchBrowserEvent('closeModal');
        $this->ClearForm();
        // return redirect('operator/guru');
    }

}
