@extends('layouts.master')

@section('title', 'Katalog Buku')

@section('title.left')
<h3>Katalog Buku</h3>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_content">
                @forelse ($buku as $item)
                <div class="col-md-55">
                    <div class="thumbnail" style="height: 400px !important">
                        <div class="image view view-first" style="height: 250px !important">
                            <img style="width: 100%; height: 100%; display: block;" src="{{ asset('img/buku') . "/" . getPicture($item->cover, 'no-pict.png') }}" />
                            <div class="mask" style="height: 100%">
                                <p>{{ $item->pengarang->nama }}</p>
                            </div>
                        </div>
                        <div class="caption">
                            <p>{{ $item->judul }}</p>
                            <span class="badge">{{ $item->kategori->nama }}</span><br><br>
                            {{-- <button class="btn btn-dark btn-sm">Pinjam</button> --}}
                        </div>
                    </div>
                </div> 
                @empty
                    <b>Maaf, Katalog Buku Tidak Tersedia</b>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
