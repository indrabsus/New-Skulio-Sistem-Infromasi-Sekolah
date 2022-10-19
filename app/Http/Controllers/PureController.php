<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class PureController extends Controller
{
    public function config(){
        return view('pure.admin.config',[
            'data' => Config::get('data')
        ]);
    }


    public function prosesconfig(Request $request){
        //  dd($validate);
        if(!isset($request->logo)){
            $validate = $request->validate([
                'notel' => 'required|numeric',
                'email' => 'required|email',
                'fb' => 'required',
                'ig' => 'required',
                'yt' => 'required',
                'nama_sekolah' => 'required',
                'desk_singkat' => 'required',
                'desk_panjang' => 'required',
                'alamat' => 'required',
                'url' => 'required',
                'token_telegram' => 'required',
                'chat_admin' => 'required',
            ]);


            $config = Profile::where('npsn',20224125)->update([
            'notel' => $request->notel,
            'email' => $request->email,
            'fb' => $request->fb,
            'ig' => $request->ig,
            'yt' => $request->yt,
            'nama_sekolah' => $request->nama_sekolah,
            'desk_singkat' => $request->desk_singkat,
            'desk_panjang' => $request->desk_panjang,
            'alamat' => $request->alamat,
            'url' => $request->url,
            'token_telegram' => $request->token_telegram,
            'chat_admin' => $request->chat_admin,
            ]);

            return redirect()->route('config')->with('status','Berhasil ubah setelan web');
        } else {
            $validate = $request->validate([
                'notel' => 'required|numeric',
                'email' => 'required|email',
                'fb' => 'required',
                'ig' => 'required',
                'yt' => 'required',
                'nama_sekolah' => 'required',
                'desk_singkat' => 'required',
                'desk_panjang' => 'required',
                'alamat' => 'required',
                'url' => 'required',
                'token_telegram' => 'required',
                'chat_admin' => 'required',
                'logo' => 'image'
            ]);
                $ext = $request->file('logo')->getClientOriginalExtension();
                $path = $request->file('logo')->storeAs('public/imgweb', 'logo.'.$ext);


                $config = Profile::where('npsn',20224125)->update([
                    'notel' => $request->notel,
                    'email' => $request->email,
                    'fb' => $request->fb,
                    'ig' => $request->ig,
                    'yt' => $request->yt,
                    'nama_sekolah' => $request->nama_sekolah,
                    'desk_singkat' => $request->desk_singkat,
                    'desk_panjang' => $request->desk_panjang,
                    'alamat' => $request->alamat,
                    'url' => $request->url,
                    'token_telegram' => $request->token_telegram,
                    'chat_admin' => $request->chat_admin,
                    'logo' =>  '/'.$path
                    ]);

                    return redirect()->route('config')->with('status','Berhasil ubah setelan web');
        }

    }
}

