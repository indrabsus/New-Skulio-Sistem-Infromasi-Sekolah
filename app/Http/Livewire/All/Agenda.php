<?php

namespace App\Http\Livewire\All;

use App\Models\Agenda as ModelsAgenda;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Agenda extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $tanggal_agenda,$kegiatan_agenda,$partner,$materi,$hasil_kegiatan,$publish;
    public $result = 10;
    public $search = '';
    public $carilevel = '';
    public function render()
    {
        if(Auth::user()->level == 'admin' || Auth::user()->level == 'kepsek' || Auth::user()->level == 'mutu'){
            $data = DB::table('agendas')
            ->orderBy('id_agenda','desc')
            ->where('kegiatan_agenda', 'like', '%'.$this->search.'%')
            ->where('level', 'like', '%'.$this->carilevel.'%')
            ->paginate($this->result);
        } else {
            $data = DB::table('agendas')
            ->orderBy('id_agenda','desc')
            ->where('kegiatan_agenda', 'like', '%'.$this->search.'%')
            ->where('level', Auth::user()->level)
            ->paginate($this->result);
        }
        return view('livewire.all.agenda',[
            'data' => $data
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function ClearForm()
    {
        $this->tanggal_agenda = '';
        $this->kegiatan_agenda = '';
        $this->partner = '';
        $this->materi = '';
        $this->hasil_kegiatan = '';
        $this->publish = '';
    }
    public function create(){
        $this->validate([
            'tanggal_agenda' => 'required',
            'kegiatan_agenda' => 'required',
            'partner' => 'required',
            'materi' => 'required',
            'hasil_kegiatan' => 'required',
            'publish' => 'required'
        ]);
        $isi = [
            'tanggal_agenda' => $this->tanggal_agenda,
            'kegiatan_agenda' => $this->kegiatan_agenda,
            'partner' => $this->partner,
            'materi' => $this->materi,
            'hasil_kegiatan' => $this->hasil_kegiatan,
            'level' => Auth::user()->level,
            'publish' => $this->publish
        ];

        $user = ModelsAgenda::create($isi);
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil Disimpan');
        $this->ClearForm();
    }
    public function edit($id) {
        $user = DB::table('agendas')
                    ->where('id_agenda',$id)
                    ->first();
                    $this->tanggal_agenda = $user->tanggal_agenda;
                    $this->kegiatan_agenda = $user->kegiatan_agenda;
                    $this->partner = $user->partner;
                    $this->materi = $user->materi;
                    $this->hasil_kegiatan = $user->hasil_kegiatan;
                    $this->publish = $user->publish;
                    $this->ids = $user->id_agenda;

    }
    public function update() {
        $this->validate([
            'tanggal_agenda' => 'required',
            'kegiatan_agenda' => 'required',
            'partner' => 'required',
            'materi' => 'required',
            'hasil_kegiatan' => 'required',
            'publish' => 'required'
        ]);
        $isi = [
            'tanggal_agenda' => $this->tanggal_agenda,
            'kegiatan_agenda' => $this->kegiatan_agenda,
            'partner' => $this->partner,
            'materi' => $this->materi,
            'hasil_kegiatan' => $this->hasil_kegiatan,
            'publish' => $this->publish
        ];

        ModelsAgenda::where('id_agenda',$this->ids)->update($isi);

        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil Diedit');
        $this->ClearForm();
    }
    public function konfirmasiHapus($id)
    {
        $user = DB::table('agendas')
            ->where('id_agenda', $id)
            ->first();

        $this->ids = $user->id_agenda;
    }

    public function delete()
    {
            $user = ModelsAgenda::where('id_agenda', $this->ids)->delete();

        session()->flash('pesan', 'Data Berhasil Dihapus');
        $this->dispatchBrowserEvent('closeModal');
        $this->ClearForm();
    }


}
