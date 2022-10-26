<?php

namespace App\Http\Livewire\Humas;

use App\Models\GuestBook;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class TamuMgmt extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama_credit,$biaya_credit,$tahun_credit;
    public $result = 10;
    public $search = '';
    public function render()
    {
        return view('livewire.humas.tamu-mgmt',[
            'data' => DB::table('guest_books')
                    ->orderBy('id_bukutamu','desc')
                    ->where('nama', 'like', '%'.$this->search.'%')
                    ->paginate($this->result)
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function konfirmasiHapus($id){
        $user = DB::table('guest_books')->where('id_bukutamu', $id)->first();
        $this->ids = $user->id_bukutamu;
    }
    public function delete(){
        GuestBook::where('id_bukutamu',$this->ids)->delete();
        $this->dispatchBrowserEvent('closeModal');
        session()->flash('pesan', 'data berhasil dihapus');
    }
}
