<?php

namespace App\Http\Livewire\Kurikulum;

use App\Models\Group;
use App\Models\Student;
use App\Models\StudentNote;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class SiswaMgmt extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama_siswa, $username, $jk_siswa,  $nohp, $confirmed, $id_kelas, $kelakuan, $keterangan, $tanggal,$kpoin;
    public $result = 10;
    public $search = '';
    public function render()
    {
        return view('livewire.kurikulum.siswa-mgmt',[
            'data' => DB::table('students')
                    ->leftJoin('users','users.id','students.id_user')
                    ->leftJoin('groups','groups.id_kelas','students.id_kelas')
                    ->orderBy('id_siswa','desc')
                    ->where('nama_siswa', 'like', '%'.$this->search.'%')
                    ->paginate($this->result),
            'kelas' => Group::all()
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function ClearForm()
    {
        $this->username = '';
        $this->nama_siswa = '';
        $this->jk_siswa = '';
        $this->nohp = '';
        $this->poin = '';
        $this->id_kelas = '';
        $this->kelakuan = '';
        $this->keterangan = '';
        $this->kpoin = '';
        $this->tanggal = '';

    }
    public function create(){
        $this->validate([
            'username' => 'required|unique:users|alpha|min:4',
            'jk_siswa' => 'required',
            'nama_siswa' => 'required',
            'nohp' => 'required|numeric',
            'id_kelas' => 'required',
            'confirmed' => 'required'
        ]);
        $isi = [
            'username' => strtolower($this->username),
            'password' => bcrypt('rahasia'),
            'level' => 'siswa',
            'confirmed' => $this->confirmed
        ];

        $user = User::create($isi);

        $isiSiswa = [
            'nama_siswa' => $this->nama_siswa,
            'jk_siswa' => $this->jk_siswa,
            'nohp' => $this->nohp,
            'id_user' => $user->id,
            'poin' => 100,
            'id_kelas' => $this->id_kelas
        ];
        Student::create($isiSiswa);
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
        $user = DB::table('students')
                    ->leftJoin('users', 'users.id', 'students.id_user')
                    ->where('users.id',$id)
                    ->first();
        $this->ids = $user->id;
        $this->id_siswa = $user->id_siswa;
        $this->nama_siswa = $user->nama_siswa;
        $this->username = $user->username;
        $this->jk_siswa = $user->jk_siswa;
        $this->nohp = $user->nohp;
        $this->id_kelas = $user->id_kelas;
        $this->confirmed = $user->confirmed;
    }

    public function update() {
        $this->validate([
            'jk_siswa' => 'required',
            'nama_siswa' => 'required',
            'nohp' => 'required|numeric',
            'id_kelas' => 'required',
            'confirmed' => 'required'
        ]);

        User::where('id',$this->ids)->update(['confirmed' => $this->confirmed]);

        $isiSiswa = [
                    'nama_siswa' => $this->nama_siswa,
                    'jk_siswa' => $this->jk_siswa,
                    'nohp' => $this->nohp,
                    'id_user' => $this->ids,
                    'id_kelas' => $this->id_kelas,
                    ];
        $get = Student::where('id_siswa',$this->id_siswa)->update($isiSiswa);
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
    public function note($id){
        $user = DB::table('students')
        ->leftJoin('users','users.id','students.id_user')
        ->leftJoin('groups','groups.id_kelas','students.id_kelas')
        ->where('students.id_siswa',$id)
        ->first();
        $this->nama_siswa = $user->nama_siswa;
        $this->id_kelas = $user->id_kelas;
        $this->id_siswa = $user->id_siswa;
        $this->poin = $user->poin;
    }
    public function updatenote(){
        $this->validate([
            'kelakuan' => 'required',
            'keterangan' => 'required',
            'kpoin' => 'required',
            'tanggal' => 'required'
        ]);
        $isi = [
            'id_siswa' => $this->id_siswa,
            'id_kelas' => $this->id_kelas,
            'kelakuan' => $this->kelakuan,
            'kpoin' => $this->kpoin,
            'keterangan' => $this->keterangan,
            'tanggal' => $this->tanggal
        ];
        StudentNote::create($isi);
        if($this->kelakuan == 'baik'){
            Student::where('id_siswa',$this->id_siswa)->update(['poin' => $this->poin + $this->kpoin]);
        } else {
            Student::where('id_siswa',$this->id_siswa)->update(['poin' => $this->poin - $this->kpoin]);
        }
        session()->flash('pesan', 'Data Berhasil disimpan');
        $this->dispatchBrowserEvent('closeModal');
        $this->ClearForm();
    }
}
