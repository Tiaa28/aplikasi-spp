<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    // protected $middleware = ['auth:siswa'];

    // public function __construct()
    // {
    //     $this->middleware('auth:siswa');
    // }


    public function index()
    {
         // Mendapatkan data siswa yang sedang login
        $siswa = Auth::guard('siswa')->user();
        // dd($siswa);

        // Memuat halaman dashboard siswa dan mengirim data siswa ke view
        return view('pages.login',['siswa' => $siswa]);
    }


    public function proses_login(Request $request)
    {
        request()->validate(
        [
            'username' => 'required',
            'password' => 'required',
        ]);


        $credentials = [
            'nisn' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        $credentialsPetugas = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
        ];

        // Coba melakukan proses autentikasi
        if (Auth::guard('siswa')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('homepage');
            // //  return redirect()->intended('/homepage');
            // // Jika berhasil login, arahkan ke halaman dashboard siswa
            // echo "siswa masuk";
            // $siswa = Auth::guard('siswa')->user();
            // echo $nis = $siswa->nama;
            // // return redirect()->route('homepage');
            // return;
        } else if(Auth::guard('petugas')->attempt($credentialsPetugas)) {
            $request->session()->regenerate();
            $petugas = Auth::guard('petugas')->user();
            // echo $nis = $petugas->nama_petugas;
            return redirect()->route('homepage');
        }

        return redirect()->route('login')
                        ->withInput()
                        ->withErrors(['login_gagal' => 'Login gagal, username atau password salah!']);

        // $kredensil = $request->only('username','password');

        //     if (Auth::attempt($kredensil)) {
        //         $user = Auth::user();
        //         if ($user->level == 'admin') {
        //             return redirect()->intended('admin');
        //         } elseif ($user->level == 'editor') {
        //             return redirect()->intended('editor');
        //         }
        //         return redirect()->intended('/');
        //     }


    }

    public function logout(Request $request)
    {
       $request->session()->flush();
       Auth::logout();
    //    return Redirect('login');
       return redirect()->route('login');
    }
}
