<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Spp;
use Illuminate\Support\Facades\Hash;

class CrudSppController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function viewDataSpp()
    {
        $checkUserLoginData =  Auth::guard('petugas')->user();
        $spps = Spp::get()->toArray();
        return view('pages.crud.spp.view',['petugas' => $checkUserLoginData, 'spps' => $spps]);
    }

    public function editDataSpp(string $id)
    {
        try {
            $checkUserLoginData =  Auth::guard('petugas')->user();
            // Retrieve the user data by ID using findOrFail
            $sppData = Spp::findOrFail($id);
            return view('pages.crud.spp.edit',['petugas' => $checkUserLoginData, 'sppData' => $sppData]);
        } catch (\Exception $e) {
            // Handle the case where the siswa is not found
            return abort(404);
        }
    }

    public function updateDataSpp(Request $request) {
        $request->validate([
            'id'=>'required',
            'tahun'=>'required',
            'nominal'=>'required',
        ]);

        try {
            $petugas = Spp::findOrFail($request->input('id'));
            $updateData = $petugas->update([
                            'tahun'=>$request->input('tahun'),
                            'nominal'=>$request->input('nominal'),
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

    public function hardDeleteDataSpp (string $id)
    {
        $spp = Spp::find($id);

        if ($spp) {
            $spp->delete(); // Soft delete the record
            return redirect()->route('crud-data-spp')->with('success', 'Spp berhasil dihapus.');
        } else {
            return redirect()->route('crud-data-spp')->with('error', 'Spp not found.');
        }
    }

    public function createDataSpp()
    {
        try {
            $checkUserLoginData =  Auth::guard('petugas')->user();
            return view('pages.crud.spp.create',['petugas' => $checkUserLoginData]);
        } catch (\Exception $e) {
            // echo "error kje";
            //  echo $e->getMessage();

            return abort(404);
        }
    }

    public function insertDataSpp(Request $request)
    {
        $request->validate([
            'tahun'=>'required',
            'nominal'=>'required',
        ]);
        try {
            $insertData = Spp::create([
                            'tahun'=>$request->input('tahun'),
                            'nominal'=>$request->input('nominal'),
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

