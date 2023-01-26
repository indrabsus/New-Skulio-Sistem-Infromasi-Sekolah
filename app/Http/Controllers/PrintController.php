<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Teacher;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrintController extends Controller
{
    public function print(){
        return view('pure.admin.print',[
            'kelas' => Group::all()
        ]);
    }
    public function dataguru(){
        $data = DB::table('teachers')
        ->leftJoin('users','users.id','teachers.id_user')
        ->orderBy('kode_guru', 'asc')->get();
        $pdf = Pdf::loadView('pdf.dataguru', [
            'data' => $data,
            'title' => 'Print Data Guru'
        ]);
        return $pdf->download('dataguru.pdf');
    }
    public function datasiswa(Request $request){
        $request->validate(['id_kelas' => 'required']);
        $data = DB::table('students')
        ->leftJoin('users','users.id','students.id_user')
        ->leftJoin('groups','groups.id_kelas','students.id_kelas')
        ->where('students.id_kelas', $request->id_kelas)
        ->orderBy('id_siswa', 'desc')->get();
        $pdf = Pdf::loadView('pdf.datasiswa', [
            'data' => $data,
            'title' => 'Print Data Siswa'
        ]);
        return $pdf->download('datasiswa.pdf');
    }
    public function datajadwal(Request $request){
        $request->validate(['hari' => 'required']);
        $data = DB::table('schedules')
        ->leftJoin('student_groups','student_groups.id_ajar','schedules.id_ajar')
        ->leftJoin('groups','groups.id_kelas','student_groups.id_kelas')
        ->leftJoin('guru_mapel_links','guru_mapel_links.id_gurumapel','student_groups.id_gurumapel')
        ->leftJoin('teachers','teachers.id_guru','guru_mapel_links.id_guru')
        ->leftJoin('subjects','subjects.id_mapel','guru_mapel_links.id_mapel')
        ->where('schedules.hari', $request->hari)
        ->orderBy('jam_a', 'asc')
        ->get();
        $pdf = Pdf::loadView('pdf.datajadwal', [
            'data' => $data,
            'title' => 'Jadwal Pelajaran',
            'hari' => $request->hari
        ]);
        return $pdf->download('jadwalmapel.pdf');
    }
    public function agendamanajerial(Request $request){
        $request->validate(['level' => 'required']);
        $data = DB::table('agendas')
        ->where('level', $request->level)
        ->orderBy('id_agenda', 'desc')
        ->get();
        $pdf = Pdf::loadView('pdf.agendamanajerial', [
            'data' => $data,
            'title' => 'Agenda Manajerial',
            'level' => ucwords($request->level)
        ])->setPaper('a4', 'landscape');
        return $pdf->download('agendamanajerial.pdf');
    }
    public function databos(Request $request){
        $request->validate(['laporan' => 'required']);
        if($request->laporan == 'credit'){
            $data = DB::table('credits')
                ->orderBy('tahun_credit', 'desc')
                ->get();
        } else {
            $data = DB::table('debits')
                ->orderBy('tahun_debit', 'desc')
                ->get();
        }
        $pdf = Pdf::loadView('pdf.databos', [
            'data' => $data,
            'title' => 'Rekapan Bantuan Operasional Sekolah',
            'ket' => ucwords($request->laporan)
        ]);
        return $pdf->download('laporan '.$request->laporan.' bos.pdf');
    }
    public function datasarpras(Request $request){
        $data = DB::table('inventaris')
        ->where('tanggal', 'like', '%'.$request->bulan.'%')
        ->orderBy('id_barang', 'desc')->get();
        $pdf = Pdf::loadView('pdf.datasarpras', [
            'data' => $data,
            'title' => 'Print Data Inventaris Barang'
        ])->setPaper('a4', 'landscape');
        return $pdf->download('datainventaris.pdf');
    }
    public function datacatatan(Request $request){
        $request->validate(['id_kelas' => 'required']);
        $data = DB::table('student_notes')
        ->leftJoin('students','students.id_siswa','student_notes.id_siswa')
        ->where('students.id_kelas', $request->id_kelas)
        ->orderBy('id_catatan', 'desc')->get();
        $kelas = DB::table('groups')->where('id_kelas', $request->id_kelas)->first();
        $grup = $kelas->nama_kelas;
        $pdf = Pdf::loadView('pdf.datacatatan', [
            'data' => $data,
            'title' => 'Print Data Catatan Siswa',
            'kelas' => $grup
        ]);
        return $pdf->download('datacatatan.pdf');
    }
    public function dataabsenguru(Request $request){
        $request->validate(['bulan' => 'required']);
        $data = DB::table('teacher_counts')
        ->leftJoin('teachers','teachers.id_guru','teacher_counts.id_guru')
        ->where('bulan', \Carbon\Carbon::parse($request->bulan)->translatedFormat('F Y'))
        ->orderBy('teachers.kode_guru', 'asc')->get();
        $hitung = DB::table('teacher_counts')->where('bulan', \Carbon\Carbon::parse($request->bulan)->translatedFormat('F Y'))->max('total_absen');
        $pdf = Pdf::loadView('pdf.dataabsenguru', [
            'data' => $data,
            'title' => 'Print Laporan Absen Guru',
            'bulan' => \Carbon\Carbon::parse($request->bulan)->translatedFormat('F Y'),
            'max' => $hitung
        ])->setPaper('a4', 'landscape');
        return $pdf->download('dataabsenguru.pdf');
    }
    public function siswaBaru($id){
        $data = DB::table('new_students')->where('id_ppdb',$id)->first();
        $pdf = Pdf::loadView('pdf.siswabaru', ['data' => $data])->setPaper('a5', 'landscape');
        return $pdf->stream($data->nisn.'datasiswabaru.pdf');
    }
    public function laporanPpdb($tanggal){
        $total = DB::table('ppdb_histories')->where('ppdb_histories.created_at','like','%'.$tanggal.'%')->sum('jumlah');
        $data = DB::table('ppdb_histories')
        ->leftJoin('new_students','new_students.id_ppdb','ppdb_histories.id_ppdb')
        ->where('ppdb_histories.created_at','like','%'.$tanggal.'%')->get();
        $pdf = Pdf::loadView('pdf.laporanppdb', ['data' => $data, 'tanggal' => $tanggal, 'total' => $total]);
        return $pdf->stream('laporanppdb.pdf');
    }
    public function kelasPpdb($id){
        $kelas = DB::table('new_groups')
        ->where('id_kelas',$id)->first();
        $jumlah = DB::table('new_students')->where('id_kelas', $id)->count();
        $laki = DB::table('new_students')->where('id_kelas', $id)->where('jenkel','l')->count();
        $perempuan = DB::table('new_students')->where('id_kelas', $id)->where('jenkel','p')->count();
        $data = DB::table('new_students')
        ->leftJoin('new_groups','new_groups.id_kelas','new_students.id_kelas')
        ->where('new_students.id_kelas',$id)->get();
        $pdf = Pdf::loadView('pdf.kelasppdb', ['data' => $data, 'kelas' => $kelas->nama_kelas, 'jumlah' => $jumlah,
    'laki' => $laki, 'perempuan' => $perempuan
    ]);
        return $pdf->stream($kelas->nama_kelas.'.pdf');
    }
}
