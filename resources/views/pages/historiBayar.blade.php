@extends('layouts.dashboard')
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row row-card-no-pd">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Histori Pembayaran SPP Anda</div>
                        </div>
                        <div class="card-body table-responsive">
                            @if (Auth::guard('petugas')->check())
                                @if ($petugas->level === 'admin')
                                    <a href="{{ route('generate-laporan') }}">
                                        <button class="btn btn-primary mb-4">Generate Laporan</button>
                                    </a>
                                @endif
                            @endif
                            <div class="card-sub">
                                Pembayaran SPP dilakukan ke Petugas!
                            </div>

                            <table id="example" class="table table-striped mt-3" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        @if (Auth::guard('petugas')->check())
                                            <th>NISN</th>
                                            <th>Siswa</th>
                                        @endif
                                        <th>Nominal</th>
                                        <th>Bulan Dibayar</th>
                                        <th>Tahun Dibayar</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Jumlah Bayar</th>
                                        <th>Petugas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($historiSPP as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            @if (Auth::guard('petugas')->check())
                                                <td>{{ $item['nisn'] }}</td>
                                                <td>{{ $item['siswa']['nama'] }}</td>
                                            @endif
                                            <td>{{ isset($item['spp']['nominal']) ? $item['spp']['nominal'] : '' }}</td>
                                            <td>{{ $item['bulan_dibayar'] }}</td>
                                            <td>{{ $item['tahun_dibayar'] }}</td>
                                            <td>{{ $item['tgl_bayar'] }}</td>
                                            <td>Rp {{ number_format($item['jumlah_bayar']) }}</td>
                                            <td>{{ isset($item['petugas']['nama_petugas']) ? $item['petugas']['nama_petugas']  : '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        @if (Auth::guard('petugas')->check())
                                            <th>NISN</th>
                                            <th>Siswa</th>
                                        @endif
                                        <th>Nominal</th>
                                        <th>Bulan Dibayar</th>
                                        <th>Tahun Dibayar</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Jumlah Bayar</th>
                                        <th>Petugas</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
