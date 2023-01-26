<?php

namespace App\Http\Livewire\Ppdb;

use App\Models\NewGroup;
use App\Models\NewStudent;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class PembagianKelas extends Component
{
    use WithPagination;
    public $nisn, $nama, $jenkel, $asal_sekolah, $minat, $nohp, $ttl, $alamat, $agama, $ids,
    $daftar, $bayardaftar, $cicilan1, $bayar1, $cicilan2, $bayar2, $cicilan3, $bayar3, $ortu, $id_kelas;
    protected $paginationTheme = 'bootstrap';
    public $result = 10;
    public $printkelas;

    public $search = '';
    public function render()
    {
        
        return view('livewire.ppdb.pembagian-kelas',[
            'data' => DB::table('new_students')
            ->leftJoin('new_groups','new_groups.id_kelas','new_students.id_kelas')
            ->orderBy('new_students.id_ppdb','desc')
            ->where('nisn', 'like', '%'.$this->search.'%')
            // ->where('ppdb_histories.jumlah','>=', 1000000)
            // ->where('new_groups.id_kelas', 'like', '%'.$this->carikelas.'%')
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
        $this->id_kelas = $data->id_kelas;
    }
    public function updateKelas(){
        $this->validate([
            'id_kelas' => 'required'
        ]);
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
}
