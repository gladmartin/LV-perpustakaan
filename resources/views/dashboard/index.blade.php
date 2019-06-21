@extends('layouts.master')

@section('title', 'Dashboard')

@section('title.left')
<h3>Dashboard</h3>
@stop

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="row top_tiles">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-users"></i></div>
                    <div class="count">{{ $jmlAnggota }}</div>
                    <h3>Anggota</h3>
                    <p>Jumlah anggota yang akitf.</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-user-secret"></i></div>
                    <div class="count">{{ $jmlPetugas }}</div>
                    <h3>Petugas</h3>
                    <p>Jumlah petugas perpustakaan.</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-book"></i></div>
                    <div class="count">{{ $jmlBuku }}</div>
                    <h3>Buku</h3>
                    <p>Koleksi buku yang tersedia (per judul).</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-bar-chart-o"></i></div>
                    <div class="count">{{ $jmlPinjam }}</div>
                    <h3>Peminjaman</h3>
                    <p>Buku yand sedang dipinjam oleh anggota.</p>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
