@extends('layouts.dashboard')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <h4 class="page-title">Selamat datang {{ Auth::guard('siswa')->check() ? $siswa->nama : '' }}
            </h4>
            <div class="row row-card-no-pd">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title mb-4">Perbarui Data diri anda</div>
                            @error('update_gagal')
                                <div class="alert col-12 col-md-6 alert-danger pl-2" role="alert">
                                    <i class="la la-close"></i> {{ $message }}
                                </div>
                            @enderror
                            @if (session('message'))
                                <div class="alert col-12 col-md-6 alert-success pl-2">
                                    @if (session('status') === 'ok')
                                        <i class="la la-check"></i>
                                    @endif
                                    {{ session('message') }}
                                </div>
                            @endif
                            <div class="progress-card">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">NISN</span>
                                </div>
                                <p class="card-category">{{ $siswa->nisn }}</p>
                            </div>
                            <div class="progress-card">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">NIS</span>
                                </div>
                                <p class="card-category">{{ $siswa->nis }}</p>
                            </div>
                            <div class="progress-card">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">KELAS</span>

                                </div>
                                <p class="card-category">{{ isset($siswa->kelas->nama_kelas) ? $siswa->kelas->nama_kelas : '' }}</p>
                            </div>
                            <form action="{{ route('user-setting-post') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">NAMA</span>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="form-group px-0 py-1">
                                            <input type="text" class="form-control" name="nama"
                                                value="{{ $siswa->nama }}" placeholder="Nama lengkap">
                                            @error('nama')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">ALAMAT</span>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="form-group px-0 py-1">
                                            <textarea class="form-control" name="alamat" rows="5">{{ $siswa->alamat }}</textarea>
                                            @error('alamat')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">NO TELPON</span>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="form-group px-0 py-1">
                                            <input type="text" class="form-control" name="telpon"
                                                value="{{ $siswa->no_telp }}" placeholder="Nomor Telpon">
                                            @error('telpon')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-action px-0">
                                    <button class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>



        </div>
    </div>
@stop
