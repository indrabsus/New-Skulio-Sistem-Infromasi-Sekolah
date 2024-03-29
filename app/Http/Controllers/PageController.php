<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\GuestBook;
use App\Models\NewStudent;
use App\Models\Staf;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PageController extends Controller
{
    public function home(){
        $data = DB::table('sliders')->get();
        $gal = DB::table('galeries')->get();
        $jurusan = DB::table('jurusans')->get();
        return view('web.home',[
            'data' => $data,
            'gal' => $gal,
            'jurusan' => $jurusan
        ]);
    }
    public function pengumuman(){
        $pengumuman = Announcement::orderBy('id_kegiatan','desc')->get();
        return view('web.kegiatan',[
            'data' => $pengumuman
        ]);
    }

    public function guru(){
        $guru = Teacher::orderBy('kode_guru','asc')->get();
        return view('web.guru',[
            'data' => $guru
        ]);
    }

    public function tendik(){
        $tendik = Staf::all();
        return view('web.tendik',[
            'data' => $tendik
        ]);
    }

    public function mapel(){
        $mapel = DB::table('guru_mapel_links')
        ->leftJoin('teachers','teachers.id_guru','guru_mapel_links.id_guru')
        ->leftJoin('subjects','subjects.id_mapel','guru_mapel_links.id_mapel')
        ->get();
        return view('web.mapel',[
            'data' => $mapel
        ]);
    }
    public function kelas(){
        $kelas = DB::table('groups')
                ->leftJoin('teachers','teachers.id_guru','groups.id_guru')
                ->get();
        return view('web.kelas',[
            'data' => $kelas
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
            'data' => $siswa
        ]);
    }

    public function jadwal(){
        $jadwal = DB::table('schedules')
        ->leftJoin('student_groups','student_groups.id_ajar','schedules.id_ajar')
        ->leftJoin('guru_mapel_links','guru_mapel_links.id_gurumapel','student_groups.id_gurumapel')
        ->leftJoin('groups','groups.id_kelas','student_groups.id_kelas')
        ->leftJoin('teachers','teachers.id_guru','guru_mapel_links.id_guru')
        ->leftJoin('subjects','subjects.id_mapel','guru_mapel_links.id_mapel')
        ->get();
        return view('web.jadwal',[
            'data' => $jadwal
        ]);
    }
    public function labkom(){
        $labkom = DB::table('labkom_schedules')
        ->leftJoin('teachers','teachers.id_guru','labkom_schedules.id_guru')
        ->leftJoin('groups','groups.id_kelas','labkom_schedules.id_kelas')
        ->leftJoin('subjects','subjects.id_mapel','labkom_schedules.id_mapel')
        ->get();
        return view('web.labkom',[
            'data' => $labkom
        ]);
    }
    public function kepsek(){
        $kepsek = DB::table('agendas')
        ->where('level','kepsek')
        ->where('publish','y')
        ->orderBy('id_agenda','desc')
        ->get();
        return view('web.kepsek',[
            'data' => $kepsek
        ]);
    }
    public function kurikulum(){
        $kurikulum = DB::table('agendas')
        ->where('level','kurikulum')
        ->where('publish','y')
        ->orderBy('id_agenda','desc')
        ->get();
        return view('web.kurikulum',[
            'data' => $kurikulum
        ]);
    }
    public function kesiswaan(){
        $kesiswaan = DB::table('agendas')
        ->where('level','kesiswaan')
        ->where('publish','y')
        ->orderBy('id_agenda','desc')
        ->get();
        return view('web.kesiswaan',[
            'data' => $kesiswaan
        ]);
    }
    public function humas(){
        $humas = DB::table('agendas')
        ->where('level','humas')
        ->where('publish','y')
        ->orderBy('id_agenda','desc')
        ->get();
        return view('web.humas',[
            'data' => $humas
        ]);
    }
    public function sarpras(){
        $sarpras = DB::table('agendas')
        ->where('level','sarpras')
        ->where('publish','y')
        ->orderBy('id_agenda','desc')
        ->get();
        return view('web.sarpras',[
            'data' => $sarpras
        ]);
    }
    public function mutu(){
        $mutu = DB::table('agendas')
        ->where('level','mutu')
        ->where('publish','y')
        ->orderBy('id_agenda','desc')
        ->get();
        return view('web.mutu',[
            'data' => $mutu
        ]);
    }
    public function tamu(){
        Config::get('data');
        return view('web.tamu');
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
        // $response = Http::get('https://api.telegram.org/bot'.Config::get('data.token_telegram').'/sendMessage?chat_id='.Config::get('data.chat_admin').'&text='.$teks);
        // $response = Http::get('https://api.telegram.org/bot5606244931:AAH9d-snV68vL16HkAtX4SVFb_24vF9AF6M/getUpdates');

        return redirect()->route('bukutamu')->with('status', 'Berhasil kirim ke tujuan');
    }

    public function ppdb(){
        Config::get('data');
        return view('web.ppdb');
    }
    public function kirimbaru(Request $request){
        $request->validate([
            'nisn' => 'required|unique:new_students|numeric',
            'nama' => 'required',
            'jenkel' => 'required',
            'asal_sekolah' => 'required',
            'minat' => 'required',
            'nohp' => 'required|numeric',
            'ttl' => 'required',
            'alamat' => 'required',
            'agama' => 'required',
            'ortu' => 'required'
        ]);

        $siswa = [
            'nisn' => $request->nisn,
            'nama' => $request->nama,
            'jenkel' => $request->jenkel,
            'asal_sekolah' => $request->asal_sekolah,
            'minat' => implode(', ', $request->minat),
            'nohp' => $request->nohp,
            'ttl' => $request->ttl,
            'alamat' => $request->alamat,
            'agama' => $request->agama,
            'ortu' => $request->ortu,
            'cicilan1' => 0,
            'cicilan2' => 0,
            'cicilan3' => 0
        ];
        $input = NewStudent::create($siswa);
        $teks = 'Pemberitahuan, ada siswa baru mendaftar dengan nama ' . $input->nama . ', dan asal sekolah dari ' . $input->asal_sekolah . ', dan ini adalah no wa saya https://wa.me/62'. substr($input->nohp, 1);
        $response = Http::get('https://api.telegram.org/bot'.Config::get('data.token_telegram').'/sendMessage?chat_id=-1001818606826,&text='.$teks);
        return redirect()->route('ppdb')->with('status', 'Anda Sudah Berhasil Daftar, untuk pembayaran silakan langsung datang ke SMK Sangkuriang 1 Cimahi dengan memberikan NOMOR NISN kepada Panitia PPDB. Terima Kasih');
    }
    public function ppdb2(){
        
        Config::get('data');
        return view('web.ppdb2');
    }
    public function cekppdb(Request $request){
        $data = DB::table('new_students')
            ->where('nisn', $request->nisn)
            ->first();
        return view('web.cekppdb', [
            'data' => $data
        ]);
    }
    
}
