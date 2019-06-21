@extends('layouts.master')

@section('title')
Detail peminjaman buku - {{ $pinjam->anggota->nama }}
@stop

@section('styles')

@endsection

@section('title.left')
<h3>Detail peminjaman</h3>
@stop


@section('content')

<div class="row">
    <div class="col-md-5 col-sm-5 col-xs-12">
        <div class="x_panel">
            <div class="row x_title">
                <div class="col-md-10 col-xs-9">
                    <h2>Detail data <span class="small">anggota</span></h2>
                </div>
                <div class="col-md-2">
                    <div class="pull-right">
                        <a href="{{ url()->previous() }}" class="btn btn-dark">Kembali</a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="text-center">
                    <img width="150px" src="{{ asset('img/avatar') .'/'. getPicture($pinjam->anggota->user->avatar) }}">
                </div>
                <table class="table">
                    <tr>
                        <th>Nama</th>
                        <td>{{ $pinjam->anggota->nama }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $pinjam->anggota->alamat }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $pinjam->anggota->user->email }}</td>
                    </tr>
                    <tr>
                        <th>Kontak</th>
                        <td>{{ $pinjam->anggota->kontak }}</td>
                    </tr>
                    <tr>
                        <th>Jenis kelamin</th>
                        <td>{{ $pinjam->anggota->jk }}</td>
                    </tr>
                    <tr>
                        <th>Agama </th>
                        <td>{{ $pinjam->anggota->agama }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-7 col-sm-7 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Detail buku <span class="small">yang dipinjam</span></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    @foreach ($pinjam->detailPinjam as $item)
                    <div class="col-xs-4 col-md-4" style="margin-bottom:50px;height:300px">
                        <div class="bg-light text-center" style="border-radius:30px;">
                            <img src="{{ asset('img/buku')."/". getPicture($item->buku->cover, 'no-pict.png') }}" height="220" width="100%">
                            <p style="padding:10px"><a href="{{ route('buku.show', $item->buku->id) }}" class="text-green">{{ $item->buku->judul }}</a></p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row">
                    <table class="table" style="margin-top:90px">
                        <tr>
                            <th>Tanggal peminjaman</th>
                            <td>{{ $pinjam->tgl_pinjam }}</td>
                        </tr>
                        <tr>
                            <th>Jatuh tempo pegembalian</th>
                            <td>{{ $pinjam->tgl_pinjam }}</td>
                        </tr>
                        <tr>
                            <th>Petugas yang menginput</th>
                            <td>{{ $pinjam->petugas->nama }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- morris.js -->
<script src="{{ asset('admin/assets') }}/vendors/raphael/raphael.min.js"></script>
<script src="{{ asset('admin/assets') }}/vendors/morris.js/morris.min.js"></script>
@endsection
