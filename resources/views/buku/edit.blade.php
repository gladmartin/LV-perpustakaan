@extends('layouts.master')

@section('title', 'Ubah buku')

@section('styles')

@endsection

@section('title.left')
<h3>Ubah buku </h3>
@stop


@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Form Ubah <small>{{ $buku->judul }}</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="text-center">
                    <b>Cover :</b><br>
                    <img src="{{ asset('img/buku') . "/" . getPicture($buku->cover, 'no-pict.png') }}" alt="" width="150">
                </div><br>
                <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                            <label for="isbn">ISBN <span class="required">*</span></label>
                            <input type="text" id="isbn" name="isbn" required="required" value="{{ old('isbn',  $buku->isbn ) }}"
                                class="form-control {{ $errors->has('isbn') ? 'parsley-error' : '' }}">
                            @if ($errors->has('isbn'))
                            <span class="text-danger">{{ $errors->first('isbn') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-8 col-sm-6 col-xs-12">
                            <label for="judul">Judul buku <span class="required">*</span>
                            </label>
                            <input id="judul" value="{{ old('judul', $buku->judul) }}"
                                class="form-control {{ $errors->has('judul') ? 'parsley-error' : '' }}" name="judul"
                                required="required" type="text">
                            @if ($errors->has('judul'))
                            <span class="text-danger">{{ $errors->first('judul') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                            <label for="pengarang_id">Pengarang <span class="required">*</span></label>
                            <select name="pengarang_id" id="pengarang_id" class="form-control">
                                @foreach ($pengarang as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $buku->pengarang->id ? 'selected' : '' }} >{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('pengarang_id'))
                            <span class="text-danger">{{ $errors->first('pengarang_id') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                            <label for="penerbit_id">Penerbit <span class="required">*</span>
                            </label>
                            <select name="penerbit_id" id="penerbit_id" class="form-control">
                                @foreach ($penerbit as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $buku->penerbit->id ? 'selected' : '' }} >{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('penerbit_id'))
                            <span class="text-danger">{{ $errors->first('penerbit_id') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-2 col-sm-6 col-xs-12">
                            <label for="tahun_terbit">Tahun terbit <span class="required">*</span></label>
                            <input type="number" id="tahun_terbit" name="tahun_terbit" required="required" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
                                class="form-control {{ $errors->has('tahun_terbit') ? 'parsley-error' : '' }}">
                            @if ($errors->has('tahun_terbit'))
                            <span class="text-danger">{{ $errors->first('tahun_terbit') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-2 col-sm-6 col-xs-12">
                            <label for="stok">Stok <span class="required">*</span></label>
                            <input type="number" id="stok" name="stok" required="required" value="{{ old('stok', $buku->stok) }}"
                                class="form-control {{ $errors->has('stok') ? 'parsley-error' : '' }}">
                            @if ($errors->has('stok'))
                            <span class="text-danger">{{ $errors->first('stok') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                            <label for="kategori_id">Kategori <span class="required">*</span></label>
                            <select name="kategori_id" id="kategori_id" class="form-control">
                                @foreach ($kategori as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $buku->kategori->id ? 'selected' : '' }} >{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('kategori_id'))
                            <span class="text-danger">{{ $errors->first('kategori_id') }}</span>
                            @endif
                        </div> 
                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                            <label for="rak_id">Rak buku <span class="required">*</span></label>
                            <select name="rak_id" id="rak_id" class="form-control">
                                @foreach ($rak as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $buku->kategori->id ? 'selected' : '' }} >{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('rak_id'))
                            <span class="text-danger">{{ $errors->first('rak_id') }}</span>
                            @endif
                        </div>   
                        <div class="form-group col-md-4 col-xs-12">
                            <label for="foto">Cover</label>
                            <input type="file" id="foto" name="foto" value="{{ old('foto') }}"
                                class="form-control {{ $errors->has('foto') ? 'parsley-error' : '' }}">
                            <span class="small">Kosongkan jika tidak ingin merubah foto.</span>
                            @if ($errors->has('foto'))
                            <span class="text-danger">{{ $errors->first('foto') }}</span>
                            @endif
                        </div>                                               
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12 col-xs-12">
                            <label for="deskripsi">Deskripsi buku <span class="required">*</span></label>
                            <textarea required rows="10" id="deskripsi" name="deskripsi" class="form-control {{ $errors->has('deskripsi') ? 'parsley-error' : '' }}">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                            @if ($errors->has('deskripsi'))
                            <span class="text-danger">{{ $errors->first('deskripsi') }}</span>
                            @endif
                        </div>                     
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-12">
                            <button type="submit" class="btn btn-success">Ubah</button>
                            <a href="{{ route('buku.index') }}" class="btn btn-dark">Batal</a>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

@endsection