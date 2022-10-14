<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class PageController extends Controller
{
    public function pengumuman(){
        Paginator::useBootstrapFour();
        $pengumuman = Announcement::orderBy('id_kegiatan','desc')->paginate(10);

        return view('web.kegiatan',[
            'data' => $pengumuman
        ]);
    }

    public function guru(){
        Paginator::useBootstrapFour();
        $guru = Teacher::orderBy('id_guru','desc')->paginate(10);

        return view('web.guru',[
            'data' => $guru
        ]);
    }
}
