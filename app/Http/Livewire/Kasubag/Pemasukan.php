<?php

namespace App\Http\Livewire\Kasubag;

use App\Models\Credit;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Pemasukan extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama_credit,$biaya_credit,$tahun_credit;
    public $result = 10;
    public $search = '';
    public $cari_tahun = '';
    public function render()
    {
        return view('livewire.kasubag.pemasukan',[
            'credit' => DB::table('credits')
                        ->sum('biaya_credit'),
            'debit' => DB::table('debits')
                        ->sum('biaya_debit'),
            'vcredit' => DB::table('credits')
                        ->orderBy('tahun_credit','desc')
                        ->where('tahun_credit', 'like', '%'.$this->cari_tahun.'%')
                        ->where('nama_credit', 'like', '%'.$this->search.'%')
                        ->paginate($this->result)
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function ClearForm()
    {
        $this->nama_credit = '';
        $this->biaya_credit = '';
        $this->tahun_credit = '';
    }
    public function create(){
        $this->validate([
            'nama_credit' => 'required',
            'biaya_credit' => 'required|numeric',
            'tahun_credit' => 'required'
        ]);
        $credit = Credit::create([
            'nama_credit' => $this->nama_credit,
            'biaya_credit' => $this->biaya_credit,
            'tahun_credit' => $this->tahun_credit
        ]);
        session()->flash('pesan', 'Data Berhasil disimpan');
        $this->dispatchBrowserEvent('closeModal');
        $this->ClearForm();
    }
    public function edit($id){
        $user = DB::table('credits')->where('id_credit', $id)->first();
        $this->nama_credit = $user->nama_credit;
        $this->biaya_credit = $user->biaya_credit;
        $this->tahun_credit = $user->tahun_credit;
        $this->ids = $user->id_credit;
    }
    public function update(){
        $this->validate([
            'nama_credit' => 'required',
            'biaya_credit' => 'required|numeric',
            'tahun_credit' => 'required'
        ]);
        $credit = Credit::where('id_credit', $this->ids)->update([
            'nama_credit' => $this->nama_credit,
            'biaya_credit' => $this->biaya_credit,
            'tahun_credit' => $this->tahun_credit
        ]);
        session()->flash('pesan', 'Data Berhasil diedit');
        $this->dispatchBrowserEvent('closeModal');
        $this->ClearForm();
    }
    public function konfirmasiHapus($id){
        $user = DB::table('credits')->where('id_credit', $id)->first();
        $this->ids = $user->id_credit;
    }
    public function delete(){
        Credit::where('id_credit',$this->ids)->delete();
        session()->flash('pesan', 'Data Berhasil dihapus');
        $this->dispatchBrowserEvent('closeModal');
        $this->ClearForm();
    }
}
