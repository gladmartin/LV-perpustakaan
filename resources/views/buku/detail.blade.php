@extends('layouts.master')

@section('title')
Detail buku - {{ $buku->judul }}
@stop

@section('title.left')
<h3>Detail buku </h3>
@stop

@section('content')

<div class="row">
    <div class="col-md-8 col-sm-8 col-xs-12">
        <div class="x_panel">
            <div class="row x_title">
                <div class="col-md-6 col-xs-9">
                    <h2>Detail buku <small>{{ $buku->judul }}</small></h2>
                </div>
                <div class="col-md-6">
                    <div class="pull-right">
                        <a href="{{ url()->previous() }}" class="btn btn-dark">Kembali</a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-striped">
                    <tr>
                        <th>Cover</th>
                        <td><img src="{{ asset('img/buku') ."/". getPicture($buku->cover, 'no-pict.png') }}" width="300"></td>
                    </tr>
                    <tr>
                        <th>ISBN</th>
                        <td>{{ $buku->isbn }}</td>
                    </tr>
                    <tr>
                        <th>Judul</th>
                        <td>{{ $buku->judul }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $buku->kategori->nama }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{!! $buku->deskripsi !!}</td>
                    </tr>
                    <tr>
                        <th>Tahun terbit</th>
                        <td>{{ $buku->tahun_terbit }}</td>
                    </tr>
                    <tr>
                        <th>Stok</th>
                        <td>{{ $buku->stok }}</td>
                    </tr>
                    <tr>
                        <th>Waktu diinput</th>
                        <td>{{ $buku->created_at }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Detail pengarang<small><a class="text-primary" href="{{ route('pengarang.show', $buku->pengarang->id) }}">{{ $buku->pengarang->nama }}</a></small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-striped">
                    <tr>
                        <th>Foto profil</th>
                        <td><img src="{{ asset('img/pengarang') ."/". getPicture($buku->pengarang->gambar) }}" width="100"></td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td><a class="text-primary" href="{{ route('pengarang.show', $buku->pengarang->id) }}">{{ $buku->pengarang->nama }}</a></td>
                    </tr>
                    <tr>
                        <th>Jumlah koleksi buku</th>
                        <td>{{ $buku->pengarang->count() }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Detail penerbit<small>{{ $buku->penerbit->nama }}</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table class="table table-striped">
                    <tr>
                        <th>Logo</th>
                        <td><img src="{{ asset('img/penerbit') ."/". getPicture($buku->penerbit->gambar) }}" width="100"></td>
                    </tr>
                    <tr>
                        <th>Penerbit</th>
                        <td>{{ $buku->penerbit->nama }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah koleksi buku</th>
                        <td>{{ $buku->penerbit->count() }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
