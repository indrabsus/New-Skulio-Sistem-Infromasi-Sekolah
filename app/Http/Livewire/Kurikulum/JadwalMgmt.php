<?php

namespace App\Http\Livewire\Kurikulum;

use App\Models\Group;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class JadwalMgmt extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $id_ajar,$hari,$jam_a,$jam_b;
    public $result = 10;
    public $carihari = '';
    public $search = '';
    public function render()
    {
        return view('livewire.kurikulum.jadwal-mgmt',[
            'data' => DB::table('schedules')
                    ->leftJoin('student_groups','student_groups.id_ajar','schedules.id_ajar')
                    ->leftJoin('guru_mapel_links','guru_mapel_links.id_gurumapel','student_groups.id_gurumapel')
                    ->leftJoin('teachers','teachers.id_guru','guru_mapel_links.id_guru')
                    ->leftJoin('subjects','subjects.id_mapel','guru_mapel_links.id_mapel')
                    ->leftJoin('groups','groups.id_kelas','student_groups.id_kelas')
                    ->where('nama_guru', 'like', '%'.$this->search.'%')
                    ->where('hari', 'like', '%'.$this->carihari.'%')
                    ->paginate($this->result),
            'guru' => DB::table('student_groups')
            ->leftJoin('groups','groups.id_kelas','student_groups.id_kelas')
            ->leftJoin('guru_mapel_links','guru_mapel_links.id_gurumapel','student_groups.id_gurumapel')
            ->leftJoin('teachers','teachers.id_guru','guru_mapel_links.id_guru')
            ->leftJoin('subjects','subjects.id_mapel','guru_mapel_links.id_mapel')
            ->get(),

        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function ClearForm()
    {
        $this->id_gurumapel = '';
        $this->id_kelas = '';
        $this->hari = '';
        $this->jam_a = '';
        $this->jam_b = '';
    }
    public function create(){
        $this->validate([
            'id_ajar' => 'required',
            'hari' => 'required',
            'jam_a' => 'required|numeric',
            'jam_b' => 'required|numeric'
        ]);
        $isi = [
            'id_ajar' => $this->id_ajar,
            'hari' => $this->hari,
            'jam_a' => $this->jam_a,
            'jam_b' => $this->jam_b,
        ];

        $user = Schedule::create($isi);

        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil Disimpan');
        $this->ClearForm();
    }
    public function edit($id) {
        $user = DB::table('schedules')
                ->leftJoin('student_groups','student_groups.id_ajar','schedules.id_ajar')
                ->leftJoin('guru_mapel_links','guru_mapel_links.id_gurumapel','student_groups.id_gurumapel')
                ->leftJoin('teachers','teachers.id_guru','guru_mapel_links.id_guru')
                ->leftJoin('subjects','subjects.id_mapel','guru_mapel_links.id_mapel')
                ->leftJoin('groups','groups.id_kelas','student_groups.id_kelas')
                ->where('id_jadwal',$id)
                ->first();
        $this->id_ajar = $user->id_ajar;
        $this->hari = $user->hari;
        $this->jam_a = $user->jam_a;
        $this->jam_b = $user->jam_b;
        $this->id_jadwal = $user->id_jadwal;
    }
    public function update() {
        $this->validate([
            'id_ajar' => 'required',
            'hari' => 'required',
            'jam_a' => 'required|numeric',
            'jam_b' => 'required|numeric'
        ]);

        Schedule::where('id_jadwal',$this->id_jadwal)->update([
            'id_ajar' => $this->id_ajar,
            'hari' => $this->hari,
            'jam_a' => $this->jam_a,
            'jam_b' => $this->jam_b,
        ]);

        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil Diedit');
        $this->ClearForm();
    }
    public function konfirmasiHapus($id)
    {
        $user = DB::table('schedules')
            ->where('id_jadwal', $id)
            ->first();

        $this->ids = $user->id_jadwal;
    }

    public function delete()
    {
            $user = Schedule::where('id_jadwal', $this->ids)->delete();

        session()->flash('pesan', 'Data Berhasil Dihapus');
        $this->dispatchBrowserEvent('closeModal');
        $this->ClearForm();
    }
}
