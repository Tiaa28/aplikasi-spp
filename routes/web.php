<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // echo Auth::guard('siswa')->user();
    if(Auth::guard('siswa')->check() ||  Auth::guard('petugas')->check() ){
         return redirect('/homepage');
    }
    return view('pages.login');
})->name('login');

Route::post('/proses_login', 'App\Http\Controllers\AuthController@proses_login')->name('proses_login');



// Siswa Routes
Route::middleware(['auth:siswa,petugas'])->group(function () {
    // Your siswa-specific routes go here
    Route::get('/homepage', 'App\Http\Controllers\Homepage@index')->name('homepage');
    Route::get('/histori-bayar', 'App\Http\Controllers\Homepage@historiBayar')->name('histori-bayar');
    Route::get('logout','App\Http\Controllers\AuthController@logout')->name('logout');
    Route::get('/user-setting', 'App\Http\Controllers\Homepage@userSetting')->name('user-setting');
    Route::post('/user-setting', 'App\Http\Controllers\Homepage@userUpdateSetting')->name('user-setting-post');
    Route::post('/petugas-setting', 'App\Http\Controllers\Homepage@petugasUpdateSetting')->name('petugas-setting-post');

});
Route::middleware(['auth:petugas'])->group(function () {
    Route::get('/data-siswa', 'App\Http\Controllers\AdminController@viewDataSiswa')->name('crud-data-siswa');
    Route::get('/data-siswa/{id}', 'App\Http\Controllers\AdminController@editDataSiswa')->name('edit-siswa');
    Route::post('/data-siswa', 'App\Http\Controllers\AdminController@updateDataSiswa')->name('update-data-siswa');
    Route::delete('/data-siswa/{id}', 'App\Http\Controllers\AdminController@softDeleteDataSiswa')->name('softdelete-data-siswa');
    Route::get('/crate-data-siswa', 'App\Http\Controllers\AdminController@createDataSiswa')->name('create-data-siswa');
    Route::post('/crate-data-siswa', 'App\Http\Controllers\AdminController@insertDataSiswa')->name('insert-data-siswa');

    //actualy you can short this code with : Route::resource('data-siswa', App\Http\Controllers\AdminController::class);

    Route::get('/data-petugas', 'App\Http\Controllers\CrudPetugasController@viewDataPetugas')->name('crud-data-petugas');
    Route::get('/data-petugas/{id}', 'App\Http\Controllers\CrudPetugasController@editDataPetugas')->name('edit-petugas');
    Route::post('/data-petugas', 'App\Http\Controllers\CrudPetugasController@updateDataPetugas')->name('update-data-petugas');
    Route::delete('/data-petugas/{id}', 'App\Http\Controllers\CrudPetugasController@hardDeleteDataPetugas')->name('harddelete-data-petugas');
    Route::get('/crate-data-petugas', 'App\Http\Controllers\CrudPetugasController@createDataPetugas')->name('create-data-petugas');
    Route::post('/crate-data-petugas', 'App\Http\Controllers\CrudPetugasController@insertDataPetugas')->name('insert-data-petugas');


    Route::get('/data-kelas', 'App\Http\Controllers\CrudKelasController@viewDataKelas')->name('crud-data-kelas');
    Route::get('/data-kelas/{id}', 'App\Http\Controllers\CrudKelasController@editDataKelas')->name('edit-kelas');
    Route::post('/data-kelas', 'App\Http\Controllers\CrudKelasController@updateDataKelas')->name('update-data-kelas');
    Route::delete('/data-kelas/{id}', 'App\Http\Controllers\CrudKelasController@hardDeleteDataKelas')->name('harddelete-data-kelas');
    Route::get('/crate-data-kelas', 'App\Http\Controllers\CrudKelasController@createDataKelas')->name('create-data-kelas');
    Route::post('/crate-data-kelas', 'App\Http\Controllers\CrudKelasController@insertDataKelas')->name('insert-data-kelas');


    Route::get('/data-spp', 'App\Http\Controllers\CrudSppController@viewDataSpp')->name('crud-data-spp');
    Route::get('/data-spp/{id}', 'App\Http\Controllers\CrudSppController@editDataSpp')->name('edit-spp');
    Route::post('/data-spp', 'App\Http\Controllers\CrudSppController@updateDataSpp')->name('update-data-spp');
    Route::delete('/data-spp/{id}', 'App\Http\Controllers\CrudSppController@hardDeleteDataSpp')->name('harddelete-data-spp');
    Route::get('/crate-data-spp', 'App\Http\Controllers\CrudSppController@createDataSpp')->name('create-data-spp');
    Route::post('/crate-data-spp', 'App\Http\Controllers\CrudSppController@insertDataSpp')->name('insert-data-spp');


    Route::get('/data-transaksi', 'App\Http\Controllers\EntriTransaksi@createTransaksi')->name('create-data-transaksi');
    Route::post('/data-transaksi', 'App\Http\Controllers\EntriTransaksi@cekDataSiswa')->name('cek-data-siswa');
    Route::post('/data-transaksi-insert', 'App\Http\Controllers\EntriTransaksi@insertSingleTransaksi')->name('create-single-data-transaksi');

    Route::get('/generate-laporan', 'App\Http\Controllers\AdminController@generateLaporan')->name('generate-laporan');

    // Route::get('pdf', 'App\Http\Controllers\PDFController@generatePDF');
});

// Route::get('/siswa/dashboard', 'SiswaDashboardController@index')->name('siswa.dashboard');


