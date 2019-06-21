@extends('layouts.master')

@section('title', 'Tambah anggota')

@section('styles')

@endsection

@section('title.left')
<h3>Tambah anggota</h3>
@stop


@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Form Tambah <small>anggota</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form action="{{ route('anggota.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="nama">Nama <span class="required">*</span>
                            </label>
                            <input id="nama" value="{{ old('nama') }}" class="form-control {{ $errors->has('nama') ? 'parsley-error' : '' }}" name="nama" required="required" type="text">
                            @if ($errors->has('nama'))
                            <span class="text-danger">{{ $errors->first('nama') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                            <label for="email">Email <span class="required">*</span></label>
                            <input type="email" id="email" name="email" required="required" value="{{ old('email') }}" class="form-control {{ $errors->has('email') ? 'parsley-error' : '' }}">
                            @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                            <label for="kontak">No hp <span class="required">*</span>
                            </label>
                            <input id="kontak" value="{{ old('kontak') }}" class="form-control {{ $errors->has('kontak') ? 'parsley-error' : '' }}" name="kontak" required="required" type="number">
                            @if ($errors->has('kontak'))
                            <span class="text-danger">{{ $errors->first('kontak') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                            <label for="jk">Jenis kelamin <span class="required">*</span>
                            </label>
                            <select name="jk" id="jk" class="optional form-control {{ $errors->has('jk') ? 'parsley-error' : '' }}">
                                <option value="L">Laki - laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            @if ($errors->has('jk'))
                            <span class="text-danger">{{ $errors->first('jk') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                            <label for="agama">Agama<span class="required">*</span>
                            </label>
                            <select name="agama" id="agama" class="optional form-control {{ $errors->has('agama') ? 'parsley-error' : '' }}">
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Budha">Budha</option>
                                <option value="Kongochu">Kongochu</option>
                                <option value="Hindu">Hindu</option>
                            </select>
                            @if ($errors->has('agama'))
                            <span class="text-danger">{{ $errors->first('agama') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                            <label for="katasandi">Kata sandi <span class="required">*</span>
                            </label>
                            <input id="katasandi" value="{{ old('katasandi') }}" class="form-control {{ $errors->has('katasandi') ? 'parsley-error' : '' }}" name="katasandi" required="required" type="password">
                            @if ($errors->has('katasandi'))
                            <span class="text-danger">{{ $errors->first('katasandi') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                            <label for="avatar">Foto profil</label>
                            <input id="avatar" value="{{ old('avatar') }}" class="form-control {{ $errors->has('avatar') ? 'parsley-error' : '' }}" name="avatar" type="file">
                            @if ($errors->has('avatar'))
                            <span class="text-danger">{{ $errors->first('avatar') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 col-sm-6 col-xs-12">
                            <label for="alamat">Alamat <span class="required">*</span></label>
                            <input id="alamat" required="required" type="text" name="alamat" value="{{ old('alamat') }}" class="form-control {{ $errors->has('alamat') ? 'parsley-error' : '' }}">
                            @if ($errors->has('alamat'))
                            <span class="text-danger">{{ $errors->first('alamat') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-12">
                            <button type="submit" class="btn btn-success">Simpan</button>
                        <button type="reset" class="btn btn-dark">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
