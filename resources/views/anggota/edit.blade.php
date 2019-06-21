@extends('layouts.master')

@section('title')
Ubah anggota {{ $anggota->nama }}
@stop

@section('styles')

@endsection

@section('title.left')
<h3>Ubah data anggota</h3>
@stop


@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Form ubah <small>{{ $anggota->nama }}</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="text-center">
                    <b>Foto profil</b><br>
                    <img src="{{ asset('img/avatar')."/". getPicture($anggota->user->avatar) }}" width="200">
                </div>
                <form action="{{ route('anggota.update', $anggota->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                            <label for="nama">Nama <span class="required">*</span>
                            </label>
                            <input id="nama" value="{{ old('nama', $anggota->nama) }}" class="form-control {{ $errors->has('nama') ? 'parsley-error' : '' }}" name="nama" required="required" type="text">
                            @if ($errors->has('nama'))
                            <span class="text-danger">{{ $errors->first('nama') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                            <label for="email">Email <span class="required">*</span></label>
                            <input type="email" disabled id="email" name="email" required="required" value="{{ old('email', $anggota->user->email) }}" class="form-control {{ $errors->has('email') ? 'parsley-error' : '' }}">
                            @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                            <label for="kontak">No hp <span class="required">*</span>
                            </label>
                            <input id="kontak" value="{{ old('kontak', $anggota->kontak) }}" class="form-control {{ $errors->has('kontak') ? 'parsley-error' : '' }}" name="kontak" required="required" type="number">
                            @if ($errors->has('kontak'))
                            <span class="text-danger">{{ $errors->first('kontak') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                            <label for="jk">Jenis kelamin <span class="required">*</span>
                            </label>
                            <select name="jk" id="jk" class="optional form-control {{ $errors->has('jk') ? 'parsley-error' : '' }}">
                                <option value="L" {{ $anggota->jk == 'L' ? 'selected' : '' }}>Laki - laki</option>
                                <option value="P" {{ $anggota->jk == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @if ($errors->has('jk'))
                            <span class="text-danger">{{ $errors->first('jk') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                            <label for="agama">Agama<span class="required">*</span>
                            </label>
                            <select name="agama" id="agama" class="optional form-control {{ $errors->has('agama') ? 'parsley-error' : '' }}">
                               <?php foreach($agama as $a): ?>
                               <option {{ $a == $anggota->agama ? 'selected' : '' }} value="{{ $a }}">{{ $a }}</option>
                               <?php endforeach ?>
                            </select>
                            @if ($errors->has('agama'))
                            <span class="text-danger">{{ $errors->first('agama') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-4 col-sm-4 col-xs-12">
                            <label for="avatar">Foto profil <span class="required">*</span>
                            </label>
                            <input id="avatar" class="form-control {{ $errors->has('avatar') ? 'parsley-error' : '' }}" name="avatar" type="file">
                            <span class="small">Kosongkan jika tidak ingin merubah</span>
                            @if ($errors->has('avatar'))
                            <span class="text-danger">{{ $errors->first('avatar') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-12">
                            <button type="submit" class="btn btn-success">Ubah</button>
                        <a href="{{ route('anggota.index') }}" class="btn btn-dark">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
