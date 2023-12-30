<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Petugas;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Spp;

class EntriTransaksi extends Controller
{
    public function createTransaksi()
    {
        try {
            $checkUserLoginData =  Auth::guard('petugas')->user();
            return view('pages.crud.transaksi.create',['petugas' => $checkUserLoginData]);
        } catch (\Exception $e) {
            return abort(404);
        }
    }

    public function cekDataSiswa(Request $request)
    {
        $request->validate([
            'nisn'=>'required|max:10',
        ]);

        try {
            $siswa = Siswa::with(['spp', 'kelas'])->findOrFail($request->input('nisn'));
            $siswaJson = $siswa->toArray();
            // print_r($siswaJson);
            $checkUserLoginData =  Auth::guard('petugas')->user();
            $bulan = [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            ];
            $nisnSiswa = $siswa->nisn;
            $currentYear = date('Y');
            $historiSPP = Pembayaran::with(['siswa', 'siswa.spp'])->where('nisn', $nisnSiswa)->get();
            $nominalSPPsekarang = Spp::where('tahun', $currentYear)->value('nominal');
            return view('pages.crud.transaksi.edit',['petugas' => $checkUserLoginData, 'siswa' => $siswaJson, 'bulan' => $bulan, 'historiSPP' => $historiSPP, 'nominalSPP' => $nominalSPPsekarang]);
        } catch (\Exception $e) {
            // echo "woy";
            // print_r($e);
            // echo $e->getMessage();
            return redirect()->back()->withErrors(['notfounddata' => $e->getMessage()]);
        }
    }

    public function insertSingleTransaksi(Request $request)
    {
        $request->validate([
            'nisn'=>'required|max:10',
            // 'tgl_bayar'=>'required',
            'bulan_dibayar'=>'required',
            'tahun_dibayar'=>'required',
            'jumlah_bayar'=>'required',
            'id_spp'=>'required',
        ]);
        $checkUserLoginData =  Auth::guard('petugas')->user();

        $tgl_bayar = date('Y-m-d');
        $id_petugas = $checkUserLoginData->id_petugas;

        try {
            $insertData = Pembayaran::create([ 
                'nisn'=> $request->input('nisn'),
                'tgl_bayar'=>$tgl_bayar,
                'bulan_dibayar'=>$request->input('bulan_dibayar'),
                'tahun_dibayar'=>$request->input('tahun_dibayar'),
                'jumlah_bayar'=>$request->input('jumlah_bayar'),
                'id_spp'=>$request->input('id_spp'),
                'id_petugas' => $id_petugas
            ]);

            if($insertData) {
                return redirect()->back()->with([
                    'message' => 'Data berhasil disimpan!',
                    'status' => 'ok',
                ]);
            } else {
                return redirect()->back()
                            ->withInput()
                            ->withErrors(['error' => 'Data gagal diperbaharui, cek kembali data yang anda masukan!']);
            }

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
        
    }
}
