<?php

namespace App\Http\Livewire\Kurikulum;

use App\Models\Kaprog as ModelKaprog;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Kaprog extends Component
{
    public $id_guru, $jurusan;
    public function render()
    {
        return view('livewire.kurikulum.kaprog',[
            'kaprog' => DB::table('kaprogs')
            ->leftJoin('teachers','teachers.id_guru','kaprogs.id_guru')
            ->get(),
            'guru' => DB::table('teachers')
                        ->get()
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function ClearForm()
    {
        $this->jurusan = '';
        $this->id_guru = '';
    }
    public function createC(){
        $this->validate([
            'jurusan' => 'required|unique:kaprogs',
            'id_guru' => 'required|unique:kaprogs'
        ]);
        $isi = [
            'jurusan' => $this->jurusan,
            'id_guru' => $this->id_guru
        ];
        ModelKaprog::create($isi);
        session()->flash('pesan', 'Data Berhasil Disimpan');
        $this->ClearForm();
        $this->emit('addc');
        // return redirect('operator/kelas');
    }
    public function editC($id){
        $data = DB::table('kaprogs')
                    ->where('id_kaprog',$id)
                    ->first();
        $this->id_kaprog = $data->id_kaprog;
        $this->jurusan = $data->jurusan;
        $this->id_guru = $data->id_guru;
    }
    public function update(){
        $this->validate([
            'id_guru' => 'unique:kaprogs'
        ]);
        $isi = [
            'jurusan' => $this->jurusan,
            'id_guru' => $this->id_guru
        ];
        ModelKaprog::where('id_kaprog', $this->id_kaprog)->update($isi);
        session()->flash('pesan', 'Data Berhasil Disimpan');
        $this->ClearForm();
        $this->emit('editc');
        // return redirect('operator/kelas');
    }

    public function konfirmasiHapus($id)
    {
        $user = DB::table('kaprogs')
            ->where('id_kaprog', $id)
            ->first();

        $this->ids = $user->id_kaprog;
    }

    public function delete()
    {
            $user = ModelKaprog::where('id_kaprog', $this->ids)->delete();

        session()->flash('pesan', 'Data Berhasil Dihapus');
        $this->ClearForm();
        $this->emit('delete');
        // return redirect('operator/kelas');
    }
    public function editK($id){
        $data = DB::table('kaprogs')
                    ->where('id_kaprog', $id)
                    ->first();
        $this->jurusan = $data->jurusan;
        $this->id_kaprog = $data->id_kaprog;
    }

    public function updateK(){
        $this->validate([
            'jurusan' => 'unique:kaprogs'
        ]);
        $isi = [
            'jurusan' => $this->jurusan,
        ];
        ModelKaprog::where('id_kaprog', $this->id_kaprog)->update($isi);
        session()->flash('pesan', 'Data Berhasil Disimpan');
        $this->ClearForm();
        $this->emit('editk');
        // return redirect('operator/kelas');
    }
}
