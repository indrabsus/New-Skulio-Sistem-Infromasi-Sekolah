<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Profile;
use App\Models\Staf;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function pengumuman(){
        $pengumuman = Announcement::orderBy('id_kegiatan','desc')->get();
        $profile = Profile::where('npsn','20224125')->firstOrFail();
        return view('web.kegiatan',[
            'data' => $pengumuman,
            'p' => $profile
        ]);
    }

    public function guru(){
        $guru = Teacher::orderBy('kode_guru','asc')->get();
        $profile = Profile::where('npsn','20224125')->firstOrFail();
        return view('web.guru',[
            'data' => $guru,
            'p' => $profile
        ]);
    }

    public function tendik(){
        $tendik = Staf::all();
        $profile = Profile::where('npsn','20224125')->firstOrFail();
        return view('web.tendik',[
            'data' => $tendik,
            'p' => $profile
        ]);
    }

    public function mapel(){
        $mapel = Subject::all();
        $profile = Profile::where('npsn','20224125')->firstOrFail();
        return view('web.mapel',[
            'data' => $mapel,
            'p' => $profile
        ]);
    }
}
