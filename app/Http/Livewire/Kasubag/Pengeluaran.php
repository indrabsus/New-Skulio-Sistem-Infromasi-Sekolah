<?php

namespace App\Http\Livewire\Kasubag;

use App\Models\Debit;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Pengeluaran extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama_debit,$biaya_debit,$tahun_debit;
    public $result = 10;
    public $search = '';
    public $cari_tahun = '';
    public function render()
    {
        return view('livewire.kasubag.pengeluaran',[
            'credit' => DB::table('credits')
                        ->sum('biaya_credit'),
            'debit' => DB::table('debits')
                        ->sum('biaya_debit'),
            'vdebit' => DB::table('debits')
                        ->orderBy('tahun_debit','desc')
                        ->where('tahun_debit', 'like', '%'.$this->cari_tahun.'%')
                        ->where('nama_debit', 'like', '%'.$this->search.'%')
                        ->paginate($this->result)
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function ClearForm()
    {
        $this->nama_debit = '';
        $this->biaya_debit = '';
        $this->tahun_debit = '';
    }
    public function create(){
        $this->validate([
            'nama_debit' => 'required',
            'biaya_debit' => 'required|numeric',
            'tahun_debit' => 'required'
        ]);
        $debit = Debit::create([
            'nama_debit' => $this->nama_debit,
            'biaya_debit' => $this->biaya_debit,
            'tahun_debit' => $this->tahun_debit
        ]);
        session()->flash('pesan', 'Data Berhasil disimpan');
        $this->dispatchBrowserEvent('closeModal');
        $this->ClearForm();
    }
    public function edit($id){
        $user = DB::table('debits')->where('id_debit', $id)->first();
        $this->nama_debit = $user->nama_debit;
        $this->biaya_debit = $user->biaya_debit;
        $this->tahun_debit = $user->tahun_debit;
        $this->ids = $user->id_debit;
    }
    public function update(){
        $this->validate([
            'nama_debit' => 'required',
            'biaya_debit' => 'required|numeric',
            'tahun_debit' => 'required'
        ]);
        $debit = Debit::where('id_debit', $this->ids)->update([
            'nama_debit' => $this->nama_debit,
            'biaya_debit' => $this->biaya_debit,
            'tahun_debit' => $this->tahun_debit
        ]);
        session()->flash('pesan', 'Data Berhasil diedit');
        $this->dispatchBrowserEvent('closeModal');
        $this->ClearForm();
    }
    public function konfirmasiHapus($id){
        $user = DB::table('debits')->where('id_debit', $id)->first();
        $this->ids = $user->id_debit;
    }
    public function delete(){
        Debit::where('id_debit',$this->ids)->delete();
        session()->flash('pesan', 'Data Berhasil dihapus');
        $this->dispatchBrowserEvent('closeModal');
        $this->ClearForm();
    }
}
