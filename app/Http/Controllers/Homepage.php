<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Spp;
use App\Models\Kelas;
use App\Models\Petugas;

class Homepage extends Controller
{
    protected $siswa;
    protected $petugas;

    function __construct()
    {
        // echo "halo";
        // $this->middleware('guest')->except('logout');

    }

    private function getUserLoginData()
    {
        if(Auth::guard('siswa')->check()) {
            return $siswa = Auth::guard('siswa')->user();
            // return view('pages.homepage',['siswa' => $siswa]);
        }else {
            return $petugas = Auth::guard('petugas')->user();
            // return view('pages.homepage',['petugas' => $petugas]);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $checkUserLoginData = $this->getUserLoginData();
        if(Auth::guard('siswa')->check()) {
            // print_r($checkUserLoginData);
            // Memuat kelas siswa
            $kelasSiswa = $checkUserLoginData->kelas;
            $checkUserLoginData->kelas = $kelasSiswa;
            // print_r($checkUserLoginData);
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

            //get data transaksi
            $nisnSiswa = $checkUserLoginData->nisn;
            $currentYear = date('Y');
            $historiSPP = Pembayaran::with(['siswa', 'siswa.spp'])->where('nisn', $nisnSiswa)->get();
            // dd($historiSPP[0]);
            $nominalSPPsekarang = Spp::where('tahun', $currentYear)->value('nominal');
            return view('pages.homepage',['siswa' => $checkUserLoginData, 'bulan' => $bulan, 'historiSPP' => $historiSPP, 'nominalSPP' => $nominalSPPsekarang]);
        } else {
            $level = $checkUserLoginData->level;
            if($level === 'admin') {
                $currentYear = date('Y');
                $totalSiswa = Siswa::count();
                $totalKelas = Kelas::count();
                $totalPetugas = Petugas::count();
                $totalPembayaran = Pembayaran::where('tahun_dibayar', $currentYear)->count();
                $checkUserLoginData->totalSiswa = $totalSiswa;
                $checkUserLoginData->totalPetugas = $totalPetugas;
                $checkUserLoginData->totalKelas = $totalKelas;
                $checkUserLoginData->totalPembayaran = $totalPembayaran;
            }
            return view('pages.homepage',['petugas' => $checkUserLoginData]);
        }
        // return view('pages.homepage');
        // if(Auth::guard('siswa')->check()) {
        //     $siswa = Auth::guard('siswa')->user();
        //     return view('pages.homepage',['siswa' => $siswa]);
        // }else {
        //     $petugas = Auth::guard('petugas')->user();
        //     return view('pages.homepage',['petugas' => $petugas]);
        // }
    }

    public function historiBayar() {
        $checkUserLoginData = $this->getUserLoginData();
        if(Auth::guard('siswa')->check()) {
            $nisnSiswa = $checkUserLoginData->nisn;
            $historiSPP = Pembayaran::with(['siswa', 'spp', 'petugas'])->where('nisn', $nisnSiswa)->get()->toArray();
            // print_r($historiSPP);
            return view('pages.historiBayar',['siswa' => $checkUserLoginData, 'historiSPP' => $historiSPP]);
        } else {
            $historiSPP = Pembayaran::with(['siswa', 'spp', 'petugas'])->get()->toArray();
            return view('pages.historiBayar',['petugas' => $checkUserLoginData, 'historiSPP' => $historiSPP]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function userSetting()
    {
        $checkUserLoginData = $this->getUserLoginData();
        if(Auth::guard('siswa')->check()) {
            $kelasSiswa = $checkUserLoginData->kelas;
            $checkUserLoginData->kelas = $kelasSiswa;
            return view('pages.setting.siswa',['siswa' => $checkUserLoginData]);
        } else {
            return view('pages.setting.petugas',['petugas' => $checkUserLoginData]);
        }
    }

    public function userUpdateSetting(Request $request)
    {
        $checkUserLoginData = $this->getUserLoginData();
        if(Auth::guard('siswa')->check()) {
            $nisnSiswa = $checkUserLoginData->nisn;
            $request->validate([
                'nama'=>'required',
                'alamat'=>'required',
                'telpon'=>'required|max:13',
            ]);

            try {
                $updateData = Siswa::where('nisn', $nisnSiswa)
                            ->update([
                                'nama'=>$request->input('nama'),
                                'alamat'=>$request->input('alamat'),
                                'no_telp'=>$request->input('telpon'),
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
            } catch (\Exception $e) { // I don't remember what exception it is specifically
                return redirect()->back()->withErrors(['update_gagal' => 'Data gagal diperbaharui, cek kembali data yang anda masukan!']);
            }

        }
    }

    public function petugasUpdateSetting(Request $request)
    {
        $checkUserLoginData = $this->getUserLoginData();
        if(Auth::guard('petugas')->check()) {
            $levelCurrent = $checkUserLoginData->level;

            if($levelCurrent != 'admin' && ($request->input('level') !== null)) {
                return redirect()->back()
                        ->withInput()
                        ->withErrors(['error' => 'Data tidak valid!']);
            }

            $request->validate([
                'username_old'=>'required',
                'username'=>'required',
                'nama_petugas'=>'required',
                'level'=>'in:admin,petugas',
            ]);

            try {
                $rawPetugas = Petugas::where('username', $request->input('username_old'));
                $updateData = $rawPetugas->update([
                                'username'=>$request->input('username'),
                                'nama_petugas'=>$request->input('nama_petugas')
                            ]);
                //add if level exist
                if($request->input('level') !== null) {
                        $rawPetugas->update([
                        'level' => $request->input('level'),
                    ]);
                }
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
            } catch (\Exception $e) { // I don't remember what exception it is specifically
                return redirect()->back()->withErrors(['update_gagal' => $e->getMessage()]);
            }

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
