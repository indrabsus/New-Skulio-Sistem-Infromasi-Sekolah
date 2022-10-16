<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index()
    {
        if (!isset(Auth::user()->level)) {
            return view('login',[
                'kelas' => Group::all()
            ]);
        } elseif (Auth::user()->level == 'admin') {
            return redirect('/admin');
        }
    }


    public function proses_login(Request $request)
    {
        request()->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ]
        );
        $kredensil = $request->only('username', 'password');
        if (Auth::attempt($kredensil)) {
            $user = Auth::user();
            if ($user->level == 'admin') {
                return redirect()->intended('admin');
            }
            return redirect()->intended('/');
        }
        return redirect()->route('loginui');
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect()->route('loginui');
    }

    public function proses_register(Request $request){
        $request->validate([
            'nama_siswa' => 'required',
            'username' => 'required|alpha_dash|min:4|unique:users',
            'password' => 'required',
            'jk_siswa' => 'required',
            'id_kelas' => 'required',
            'nohp' => 'required'
        ]);

        $inputUser = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'level' => 'siswa',
            'confirmed' => 'n'
        ]);
        $inputStudent = Student::create([
            'nama_siswa' => $request->nama_siswa,
            'jk_siswa' => $request->jk_siswa,
            'nohp' => $request->nohp,
            'id_user' => $inputUser->id,
            'id_kelas' => $request->id_kelas,
            'poin' => 100
        ]);
        return redirect()->route('loginui')->with('status', 'Berhasil daftar tunggu ACC walikelas/admin');
    }
}
