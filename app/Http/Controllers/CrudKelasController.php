<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;

class CrudKelasController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function viewDataKelas()
    {
        $checkUserLoginData =  Auth::guard('petugas')->user();
        $kelass = Kelas::get()->toArray();
        return view('pages.crud.kelas.view',['petugas' => $checkUserLoginData, 'kelass' => $kelass]);
    }

    public function editDataKelas(string $id)
    {
        try {
            $checkUserLoginData =  Auth::guard('petugas')->user();
            // Retrieve the user data by ID using findOrFail
            $kelasData = Kelas::findOrFail($id);
            return view('pages.crud.kelas.edit',['petugas' => $checkUserLoginData, 'kelasData' => $kelasData]);
        } catch (\Exception $e) {
            // Handle the case where the siswa is not found
            return abort(404);
        }
    }

    public function updateDataKelas(Request $request) {
        $request->validate([
            'id'=>'required',
            'nama_kelas'=>'required|max:10',
            'kompetensi_keahlian'=>'required',
        ]);

        try {
            $kelas = Kelas::findOrFail($request->input('id'));
            $updateData = $kelas->update([
                            'nama_kelas'=>$request->input('nama_kelas'),
                            'kompetensi_keahlian'=>$request->input('kompetensi_keahlian'),
                        ]);
            if ($updateData > 0) {
                    return redirect()->back()->with([
                        'message' => 'Data berhasil diperbaharui!',
                        'status' => 'ok',
                    ]);
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

    public function hardDeleteDataKelas (string $id)
    {
        $kelas = Kelas::find($id);

        if ($kelas) {
            $kelas->delete(); // Soft delete the record
            return redirect()->route('crud-data-kelas')->with('success', 'Kelas berhasil dihapus.');
        } else {
            return redirect()->route('crud-data-kelas')->with('error', 'Kelas not found.');
        }
    }

    public function createDataKelas()
    {
        try {
            $checkUserLoginData =  Auth::guard('petugas')->user();
            return view('pages.crud.kelas.create',['petugas' => $checkUserLoginData]);
        } catch (\Exception $e) {
            // echo "error kje";
            //  echo $e->getMessage();

            return abort(404);
        }
    }

    public function insertDataKelas(Request $request)
    {
        $request->validate([
            'nama_kelas'=>'required|max:10',
            'kompetensi_keahlian'=>'required',
        ]);
        try {
            $insertData = Kelas::create([
                            'nama_kelas'=>$request->input('nama_kelas'),
                            'kompetensi_keahlian'=>$request->input('kompetensi_keahlian'),
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



}

