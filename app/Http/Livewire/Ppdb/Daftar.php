<?php

namespace App\Http\Livewire\Ppdb;

use App\Models\NewGroup;
use App\Models\NewStudent;
use App\Models\PpdbHistory;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Daftar extends Component
{
    use WithPagination;
    public $nisn, $nama, $jenkel, $asal_sekolah, $minat, $nohp, $ttl, $alamat, $agama, $ids,
    $daftar, $bayardaftar, $cicilan1, $bayar1, $cicilan2, $bayar2, $cicilan3, $bayar3, $ortu, $id_kelas;
    protected $paginationTheme = 'bootstrap';
    public $tanggal = '';
    public $result = 10;
    public $sort = 'asc';

    public $search = '';
    public function render()
    {
        return view('livewire.ppdb.daftar',[
            'data' => DB::table('new_students')
            ->leftJoin('new_groups','new_groups.id_kelas','new_students.id_kelas')
            ->orderBy('no_urut',$this->sort)
            ->where('nisn', 'like', '%'.$this->search.'%')
            ->where('daftar', 150000)
            ->paginate($this->result),
            'uangdaftar' => DB::table('new_students')
            ->sum('daftar'),
            'kelas' => DB::table('new_groups')->get(),
            'uangppdb' => DB::table('new_students')->sum('cicilan1')+DB::table('new_students')->sum('cicilan2')+DB::table('new_students')->sum('cicilan3')
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function detail($id){
        $data = DB::table('new_students')
            ->where('id_ppdb', $id)
            ->first();
        $this->nisn = $data->nisn;
        $this->nama = $data->nama;
        $this->jenkel = $data->jenkel;
        $this->ortu = $data->ortu;
        $this->ttl = $data->ttl;
        $this->agama = $data->agama;
        $this->alamat = $data->alamat;
        $this->nohp = $data->nohp;
        $this->asal_sekolah = $data->asal_sekolah;
        $this->minat = $data->minat;
        $this->daftar = $data->daftar;
        $this->bayardaftar = $data->bayardaftar;
        $this->cicilan1 = $data->cicilan1;
        $this->bayar1 = $data->bayar1;
        $this->cicilan2 = $data->cicilan2;
        $this->bayar2 = $data->bayar2;
        $this->cicilan3 = $data->cicilan3;
        $this->bayar3 = $data->bayar3;
    }
    public function bayar($id){
        $data = DB::table('new_students')
            ->where('id_ppdb', $id)
            ->first();
            $this->ids = $data->id_ppdb;
            $this->daftar = $data->daftar;
            $this->bayardaftar = $data->bayardaftar;
            $this->cicilan1 = $data->cicilan1;
            $this->bayar1 = $data->bayar1;
            $this->cicilan2 = $data->cicilan2;
            $this->bayar2 = $data->bayar2;
            $this->cicilan3 = $data->cicilan3;
            $this->bayar3 = $data->bayar3;
    }
    public function updateBayar(){
        $this->validate([
            'daftar' => 'required|numeric',
            'cicilan1' => 'required|numeric',
            'cicilan2' => 'required|numeric',
            'cicilan3' => 'required|numeric',
        ]);
        $bayar = [
            'daftar' => $this->daftar,
            'bayardaftar' => $this->bayardaftar,
            'cicilan1' => $this->cicilan1,
            'bayar1' => $this->bayar1,
            'cicilan2' => $this->cicilan2,
            'bayar2' => $this->bayar2,
            'cicilan3' => $this->cicilan3,
            'bayar3' => $this->bayar3
        ];
        $input = NewStudent::where('id_ppdb', $this->ids)->update($bayar);
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil diupdate');
    }
    public function clearForm(){
        $this->id_kelas = '';
    }
    public function kelas($id){
        $data = DB::table('new_students')
        ->where('id_ppdb',$id)
        ->first();
        $this->ids = $data->id_ppdb;
    }
    public function updateKelas(){
        $hitung = DB::table('new_students')->where('id_kelas', $this->id_kelas)->count();
        if($hitung >= 36){
            $this->dispatchBrowserEvent('closeModal');
            session()->flash('gagal', 'Jumlah siswa melebihi batas');
            $this->clearForm();
        } else {
         $input = NewStudent::where('id_ppdb', $this->ids)->update(['id_kelas' => $this->id_kelas]);
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil diupdate');
        $this->clearForm();

            
        }
    }
    public function cicil1($id){
        $data = DB::table('new_students')
            ->where('id_ppdb', $id)
            ->first();
            $this->ids = $data->id_ppdb;
            $this->cicilan1 = $data->cicilan1;
        $this->nama = $data->nama;
    }
    public function updateCicil1(){
        $this->validate([
            'cicilan1' => 'required|numeric',
        ]);
        $bayar = [
            'cicilan1' => $this->cicilan1,
            'bayar1' => now()
        ];
        $history = PpdbHistory::create([
            'id_ppdb' => $this->ids,
            'jenis' => 'ppdb',
            'jumlah' => $this->cicilan1,
        ]);
        $input = NewStudent::where('id_ppdb', $this->ids)->update($bayar);
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil diupdate');
    }
    public function cicil2($id){
        $data = DB::table('new_students')
            ->where('id_ppdb', $id)
            ->first();
            $this->ids = $data->id_ppdb;
            $this->cicilan2 = $data->cicilan2;
        $this->nama = $data->nama;
    }
    public function updateCicil2(){
        $this->validate([
            'cicilan2' => 'required|numeric',
        ]);
        $bayar = [
            'cicilan2' => $this->cicilan2,
            'bayar2' => now()
        ];
        $history = PpdbHistory::create([
            'id_ppdb' => $this->ids,
            'jenis' => 'ppdb',
            'jumlah' => $this->cicilan2,
        ]);
        $input = NewStudent::where('id_ppdb', $this->ids)->update($bayar);
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil diupdate');
    }
    public function cicil3($id){
        $data = DB::table('new_students')
            ->where('id_ppdb', $id)
            ->first();
            $this->ids = $data->id_ppdb;
            $this->cicilan3 = $data->cicilan3;
        $this->nama = $data->nama;
    }
    public function updateCicil3(){
        $this->validate([
            'cicilan3' => 'required|numeric',
        ]);
        $bayar = [
            'cicilan3' => $this->cicilan3,
            'bayar3' => now()
        ];
        $history = PpdbHistory::create([
            'id_ppdb' => $this->ids,
            'jenis' => 'ppdb',
            'jumlah' => $this->cicilan3,
        ]);
        $input = NewStudent::where('id_ppdb', $this->ids)->update($bayar);
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil diupdate');
    }
}
