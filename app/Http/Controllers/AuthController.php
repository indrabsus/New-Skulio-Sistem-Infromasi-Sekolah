<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index()
    {
        if (!isset(Auth::user()->level)) {
            return view('web.kegiatan');
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
        return redirect()->route('login');
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect()->route('login');
    }

    public function login()
    {
        if (!isset(Auth::user()->level)) {
            return redirect('/');
        } elseif (Auth::user()->level == 'admin') {
            return redirect('/admin');
        }
    }
}
