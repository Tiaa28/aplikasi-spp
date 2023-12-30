@extends('layouts.dashboard')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <h4 class="page-title">Selamat datang {{ Auth::guard('petugas')->check() ? $petugas->nama_petugas : '' }}
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
                            @error('error')
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
                            <form action="{{ route('petugas-setting-post') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">USERNAME</span>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="form-group px-0 py-1">
                                        <input type="hidden" class="form-control" name="username_old"
                                                value="{{ $petugas->username }}" placeholder="Username lengkap">
                                            <input type="text" class="form-control" name="username"
                                                value="{{ $petugas->username }}" placeholder="Username lengkap">
                                            @error('username')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="progress-card">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">NAMA</span>
                                    </div>
                                    <div class="col-12 col-md-6 p-0">
                                        <div class="form-group px-0 py-1">
                                            <input type="text" class="form-control" name="nama_petugas"
                                                value="{{ $petugas->nama_petugas }}" placeholder="Nama lengkap">
                                            @error('nama_petugas')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @if (Auth::guard('petugas')->check())
                                    @if ($petugas->level === 'admin')
                                    <div class="progress-card">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted">LEVEL</span>
                                        </div>
                                        <div class="col-12 col-md-6 p-0">
                                            <div class="form-group px-0 py-1">
                                                <select class="form-control input-square" name="level">
                                                    <option value="" disabled>Pilih Level</option>
                                                    <option value="admin" {{ $petugas->level === 'admin' ? 'selected' : '' }}>Admin</option>
                                                    <option value="petugas" {{ $petugas->level === 'petugas' ? 'selected' : '' }}>Petugas</option>
                                                </select>
                                                @error('level')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endif
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
