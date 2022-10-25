<?php

namespace App\Http\Livewire\Guru;

use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class FileUser extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nama_file,$file_path,$jenis;
    public $result = 10;
    public $search = '';
    public function render()
    {
        if(Auth::user()->level == 'admin' || Auth::user()->level == 'kurikulum'){
            $data = DB::table('files')
            ->leftJoin('users','users.id','files.id_user')
            ->orderBy('id_file','desc')
            ->where('nama_file', 'like', '%'.$this->search.'%')
            ->paginate($this->result);
        } else {
            $data = DB::table('files')
            ->orderBy('id_file','desc')
            ->where('nama_file', 'like', '%'.$this->search.'%')
            ->where('id_user', Auth::user()->id)
            ->paginate($this->result);
        }
        return view('livewire.guru.file-user',[
            'data' => $data
        ])
        ->extends('layouts.admin.app')
        ->section('content');
    }
    public function clearForm(){
        $this->nama_file = '';
        $this->file_pathh = '';
        $this->jenis = '';
    }
    public function create(){
        if($this->jenis == 'url'){
            $this->validate([
                'file_path' => 'required',
                'nama_file' => 'required',
                'jenis' => 'required'
            ]);
            File::create([
                'nama_file' => $this->nama_file,
                'file_path' => $this->file_path,
                'ekstensi' => 'link',
                'jenis' => $this->jenis,
                'id_user' => Auth::user()->id
            ]);
            session()->flash('pesan','Data berhasil diupload');
            $this->clearForm();
            $this->dispatchBrowserEvent('closeModal');
        }
        $this->validate([
            'file_path' => 'required|max:50000|mimes:xlsx,doc,docx,ppt,pptx,ods,odt,odp',
            'nama_file' => 'required',
            'jenis' => 'required'
        ]);

        $ext = $this->file_path->getClientOriginalExtension();
        $path = $this->file_path->storeAs('public/'.Auth::user()->username, $this->nama_file.date('dmy-his', strtotime(now())).'.'.$ext);
        File::create([
            'nama_file' => $this->nama_file.'.'.$ext,
            'file_path' => $path,
            'ekstensi' => $ext,
            'jenis' => $this->jenis,
            'id_user' => Auth::user()->id
        ]);
        session()->flash('pesan','Data berhasil diupload');
        $this->clearForm();
        $this->dispatchBrowserEvent('closeModal');
    }
    public function download($id){
        $file = DB::table('files')->where('id_file', $id)->first();
        return response()->download(Config::get('public').'/'.$file->file_path);
    }
    public function konfirmasiHapus($id){
        $file = DB::table('files')->where('id_file', $id)->first();
        $this->ids = $file->id_file;
    }
    public function delete(){
        File::where('id_file',$this->ids)->delete();
        session()->flash('pesan','Data berhasil dihapus');
        $this->clearForm();
        $this->dispatchBrowserEvent('closeModal');
    }
}
