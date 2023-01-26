<?php

namespace App\Http\Livewire\Ppdb;

use App\Models\NewGroup;
use App\Models\NewStudent;
use App\Models\PpdbHistory;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class BelumRegis extends Component
{
    use WithPagination;
    public $nisn, $nama, $jenkel, $asal_sekolah, $minat, $nohp, $ttl, $alamat, $agama, $ids,
    $daftar, $bayardaftar, $cicilan1, $bayar1, $cicilan2, $bayar2, $cicilan3, $bayar3, $ortu, $id_kelas;
    protected $paginationTheme = 'bootstrap';
    public $result = 10;

    public $search = '';
    public function render()
    {
        return view('livewire.ppdb.belum-regis',[
            'data' => DB::table('new_students')
            ->leftJoin('new_groups','new_groups.id_kelas','new_students.id_kelas')
            ->orderBy('id_ppdb','desc')
            ->where('nisn', 'like', '%'.$this->search.'%')
            ->where('daftar', null)
            ->paginate($this->result),
            'uangdaftar' => DB::table('new_students')
            ->sum('daftar'),
            'kelas' => DB::table('new_groups')->get(),
            'uangppdb' => DB::table('new_students')->sum('cicilan1')+DB::table('new_students')->sum('cicilan2')+DB::table('new_students')->sum('cicilan3')
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    // public function detail($id){
    //     $data = DB::table('new_students')
    //         ->where('id_ppdb', $id)
    //         ->first();
    //     $this->nisn = $data->nisn;
    //     $this->nama = $data->nama;
    //     $this->jenkel = $data->jenkel;
    //     $this->ortu = $data->ortu;
    //     $this->ttl = $data->ttl;
    //     $this->agama = $data->agama;
    //     $this->alamat = $data->alamat;
    //     $this->nohp = $data->nohp;
    //     $this->asal_sekolah = $data->asal_sekolah;
    //     $this->minat = $data->minat;
    //     $this->daftar = $data->daftar;
    //     $this->bayardaftar = $data->bayardaftar;
    //     $this->cicilan1 = $data->cicilan1;
    //     $this->bayar1 = $data->bayar1;
    //     $this->cicilan2 = $data->cicilan2;
    //     $this->bayar2 = $data->bayar2;
    //     $this->cicilan3 = $data->cicilan3;
    //     $this->bayar3 = $data->bayar3;
    // }
    public function bayar($id){
        $data = DB::table('new_students')
            ->where('id_ppdb', $id)
            ->first();
            $this->ids = $data->id_ppdb;
            $this->daftar = $data->daftar;
    }
    public function updateBayar(){
        $this->validate([
            'daftar' => 'required|numeric'
        ]);
        $test = DB::table('new_students')->latest('no_urut')->first();
        $bayar = [
            'daftar' => $this->daftar,
            'bayardaftar' => now(),
            'no_urut' => $test->no_urut+1
        ];
        $history = PpdbHistory::create([
            'id_ppdb' => $this->ids,
            'jenis' => 'daftar',
            'jumlah' => 150000
        ]);
        $input = NewStudent::where('id_ppdb', $this->ids)->update($bayar);
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'Data Berhasil diupdate');
    }
    
}
