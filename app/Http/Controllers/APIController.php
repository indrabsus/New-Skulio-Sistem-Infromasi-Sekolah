<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class APIController extends Controller
{
    public function pengumuman($api){
        if(Config::get('token') == $api){
        $pengumuman = Announcement::all();
        return response()->json([
            'data' => $pengumuman,
            'status' => 'sukses'
        ]);
    }
    return response()->json([
        'status' => 'gagal'
    ]);
    }
}
