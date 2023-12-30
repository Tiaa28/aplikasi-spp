<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Spp;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Hash;
use PDF;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function viewDataSiswa()
    {
        $checkUserLoginData =  Auth::guard('petugas')->user();
        $siswas = Siswa::with(['spp', 'kelas'])->get()->toArray();
        return view('pages.crud.siswa.view',['petugas' => $checkUserLoginData, 'siswas' => $siswas]);
    }

    public function editDataSiswa(string $id)
    {
        try {
            $checkUserLoginData =  Auth::guard('petugas')->user();
            // Retrieve the user data by ID using findOrFail
            $siswa = Siswa::with(['spp', 'kelas'])->findOrFail($id);
            $kelass = Kelas::get();
            $spps = Spp::get();
            return view('pages.crud.siswa.edit',['petugas' => $checkUserLoginData, 'siswa' => $siswa, 'kelass' => $kelass, 'spps' => $spps]);
        } catch (\Exception $e) {
            // Handle the case where the siswa is not found
            return abort(404);
        }
    }

    public function updateDataSiswa(Request $request) {
        $request->validate([
            'oldnisn'=>'required|max:10',
            'nisn'=>'required|max:10',
            'nis'=>'required|max:10',
            'kelas'=>'required',
            'nama'=>'required',
            'alamat'=>'required',
            'telpon'=>'required|max:13',
            'spp'=>'required',
            'password'=>'confirmed',
        ]);
        try {
            $siswa = Siswa::findOrFail($request->input('oldnisn'));
            $updateData = $siswa->update([
                            'nisn'=>$request->input('nisn'),
                            'nis'=>$request->input('nis'),
                            'id_kelas'=>$request->input('kelas'),
                            'nama'=>$request->input('nama'),
                            'alamat'=>$request->input('alamat'),
                            'no_telp'=>$request->input('telpon'),
                            'id_spp'=>$request->input('spp'),
                        ]);
            //add if password exist
            if($request->input('password') !== null) {
                 $updateData = $siswa->update([
                    'password' => Hash::make($request->input('password')),
                ]);
            }
            if ($updateData > 0) {
                    if($request->input('oldnisn') != $request->input('nisn')) {
                        $url = "/data-siswa/{$request->input('nisn')}";
                        return redirect($url)->with([
                            'message' => 'Data berhasil diperbaharui!',
                            'status' => 'ok',
                        ]);
                    } else {
                        return redirect()->back()->with([
                            'message' => 'Data berhasil diperbaharui!',
                            'status' => 'ok',
                        ]);

                    }
                }else {
                    return redirect()->back()
                            ->withInput()
                            ->withErrors(['update_gagal' => 'Data gagal diperbaharui, cek kembali data yang anda masukan!']);
                }
        } catch (\Exception $e) {
            // echo "error kje";
            //  echo $e->getMessage();
            return redirect()->back()->withErrors(['update_gagal' => 'Data gagal diperbaharui, cek kembali data yang anda masukan!']);
        }

    }

    public function softDeleteDataSiswa (string $id)
    {
        $siswa = Siswa::find($id);

        if ($siswa) {
            $siswa->delete(); // Soft delete the record
            return redirect()->route('crud-data-siswa')->with('success', 'Siswa berhasil dihapus.');
        } else {
            return redirect()->route('crud-data-siswa')->with('error', 'Siswa not found.');
        }
    }

    public function createDataSiswa()
    {
        try {
            $checkUserLoginData =  Auth::guard('petugas')->user();

            $kelass = Kelas::get();
            $spps = Spp::get();
            return view('pages.crud.siswa.create',['petugas' => $checkUserLoginData, 'kelass' => $kelass, 'spps' => $spps]);
        } catch (\Exception $e) {
            // echo "error kje";
            //  echo $e->getMessage();

            return abort(404);
        }
    }

    public function insertDataSiswa(Request $request)
    {
        $request->validate([
            'nisn'=>'required|max:10',
            'nis'=>'required|max:10',
            'kelas'=>'required',
            'nama'=>'required',
            'alamat'=>'required',
            'telpon'=>'required|max:13',
            'spp'=>'required',
            'password'=>'required|confirmed',
        ]);
        try {
            $insertData = Siswa::create([
                            'nisn'=>$request->input('nisn'),
                            'nis'=>$request->input('nis'),
                            'id_kelas'=>$request->input('kelas'),
                            'nama'=>$request->input('nama'),
                            'alamat'=>$request->input('alamat'),
                            'no_telp'=>$request->input('telpon'),
                            'id_spp'=>$request->input('spp'),
                            'password'=>Hash::make($request->input('password')),
                        ]);
            //add if password exist
            // print_r($insertData);
            if ($insertData) {
                    return redirect()->back()->with([
                        'message' => 'Data berhasil disimpan!',
                        'status' => 'ok',
                    ]);
                }else {
                    return redirect()->back()
                            ->withInput()
                            ->withErrors(['create_gagal' => 'Data gagal diperbaharui, cek kembali data yang anda masukan!']);
                }
        } catch (\Exception $e) {
            // echo "error kje";
            //  echo $e->getMessage();
            return redirect()->back()->withErrors(['create_gagal' => 'Data gagal diperbaharui, cek kembali data yang anda masukan!, pastikan tidak ada duplikasi data!']);
        }
    }

    public function generateLaporan()
    {
        $checkUserLoginData =  Auth::guard('petugas')->user();
        $historiSPP = Pembayaran::with(['siswa', 'spp', 'petugas'])->get()->toArray();
        // return view('pages.historiBayar',['petugas' => $checkUserLoginData, 'historiSPP' => $historiSPP]);

        // $pdf = PDF::loadView('pages.historiBayar',['petugas' => $checkUserLoginData, 'historiSPP' => $historiSPP]);
        $pdf = PDF::loadView('pdf.example', ['petugas' => $checkUserLoginData, 'historiSPP' => $historiSPP]);
        $pdf->setPaper('a4','landscape');
        return $pdf->stream('ejemplo.pdf');
        
    }

}
