<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\GuestBook;
use App\Models\Staf;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PageController extends Controller
{
    public function pengumuman(){
        $pengumuman = Announcement::orderBy('id_kegiatan','desc')->get();
        return view('web.kegiatan',[
            'data' => $pengumuman,
            'p' => Config::get('data')
        ]);
    }

    public function guru(){
        $guru = Teacher::orderBy('kode_guru','asc')->get();
        return view('web.guru',[
            'data' => $guru,
            'p' => Config::get('data')
        ]);
    }

    public function tendik(){
        $tendik = Staf::all();
        return view('web.tendik',[
            'data' => $tendik,
            'p' => Config::get('data')
        ]);
    }

    public function mapel(){
        $mapel = DB::table('guru_mapel_links')
        ->leftJoin('teachers','teachers.id_guru','guru_mapel_links.id_guru')
        ->leftJoin('subjects','subjects.id_mapel','guru_mapel_links.id_mapel')
        ->get();
        return view('web.mapel',[
            'data' => $mapel,
            'p' => Config::get('data')
        ]);
    }
    public function kelas(){
        $kelas = DB::table('groups')
                ->leftJoin('teachers','teachers.id_guru','groups.id_guru')
                ->get();
        return view('web.kelas',[
            'data' => $kelas,
            'p' => Config::get('data')
        ]);
    }
    public function siswa(){
        $siswa = DB::table('users')
        ->leftJoin('students','students.id_user','users.id')
        ->leftJoin('groups','groups.id_kelas','students.id_kelas')
        ->where('confirmed','y')
        ->orderBy('id_siswa','desc')
        ->get();
        return view('web.siswa',[
            'data' => $siswa,
            'p' => Config::get('data')
        ]);
    }

    public function jadwal(){
        $jadwal = DB::table('schedules')
        ->leftJoin('guru_mapel_links','guru_mapel_links.id_gurumapel','schedules.id_gurumapel')
        ->leftJoin('groups','groups.id_kelas','schedules.id_kelas')
        ->leftJoin('teachers','teachers.id_guru','guru_mapel_links.id_guru')
        ->leftJoin('subjects','subjects.id_mapel','guru_mapel_links.id_mapel')
        ->get();
        return view('web.jadwal',[
            'data' => $jadwal,
            'p' => Config::get('data')
        ]);
    }
    public function labkom(){
        $labkom = DB::table('labkom_schedules')
        ->leftJoin('teachers','teachers.id_guru','labkom_schedules.id_guru')
        ->leftJoin('groups','groups.id_kelas','labkom_schedules.id_kelas')
        ->leftJoin('subjects','subjects.id_mapel','labkom_schedules.id_mapel')
        ->get();
        return view('web.labkom',[
            'data' => $labkom,
            'p' => Config::get('data')
        ]);
    }
    public function kepsek(){
        $kepsek = DB::table('agendas')
        ->where('level','kepsek')
        ->where('publish','y')
        ->orderBy('id_agenda','desc')
        ->get();
        return view('web.kepsek',[
            'data' => $kepsek,
            'p' => Config::get('data')
        ]);
    }
    public function kurikulum(){
        $kurikulum = DB::table('agendas')
        ->where('level','kurikulum')
        ->where('publish','y')
        ->orderBy('id_agenda','desc')
        ->get();
        return view('web.kurikulum',[
            'data' => $kurikulum,
            'p' => Config::get('data')
        ]);
    }
    public function kesiswaan(){
        $kesiswaan = DB::table('agendas')
        ->where('level','kesiswaan')
        ->where('publish','y')
        ->orderBy('id_agenda','desc')
        ->get();
        return view('web.kesiswaan',[
            'data' => $kesiswaan,
            'p' => Config::get('data')
        ]);
    }
    public function humas(){
        $humas = DB::table('agendas')
        ->where('level','humas')
        ->where('publish','y')
        ->orderBy('id_agenda','desc')
        ->get();
        return view('web.humas',[
            'data' => $humas,
            'p' => Config::get('data')
        ]);
    }
    public function sarpras(){
        $sarpras = DB::table('agendas')
        ->where('level','sarpras')
        ->where('publish','y')
        ->orderBy('id_agenda','desc')
        ->get();
        return view('web.sarpras',[
            'data' => $sarpras,
            'p' => Config::get('data')
        ]);
    }
    public function mutu(){
        $mutu = DB::table('agendas')
        ->where('level','mutu')
        ->where('publish','y')
        ->orderBy('id_agenda','desc')
        ->get();
        return view('web.mutu',[
            'data' => $mutu,
            'p' => Config::get('data')
        ]);
    }
    public function tamu(){
        Config::get('data');
        return view('web.tamu',[
            'p' => Config::get('data')
        ]);
    }
    public function kirimTamu(Request $request){
        $request->validate([
            'nama' => 'required',
            'instansi' => 'required',
            'nohp' => 'required|numeric',
            'keperluan' => 'required',
            'divisi' => 'required'
        ]);

        $tamu = GuestBook::create($request->all());
        $teks = 'Ada notifikasi baru, tamu bernama '.$tamu->nama.', dari instansi : '.$tamu->instansi.' dengan keperluan '.$tamu->keperluan.' dan ditujukan ke '.$tamu->divisi;
        $response = Http::get('https://api.telegram.org/bot'.Config::get('data.token_telegram').'/sendMessage?chat_id='.Config::get('data.chat_admin').'&text='.$teks);
        // $response = Http::get('https://api.telegram.org/bot5606244931:AAH9d-snV68vL16HkAtX4SVFb_24vF9AF6M/getUpdates');

        return redirect()->route('bukutamu')->with('status', 'Berhasil kirim ke tujuan');
    }
}
