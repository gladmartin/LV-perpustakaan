@extends('layouts.master')

@section('title')
Detail petugas {{ $petugas->nama }}
@stop

@section('styles')

@endsection

@section('title.left')
<h3>Detail data petugas</h3>
@stop


@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="row x_title">
                <div class="col-md-10 col-xs-9">
                    <h2>Biodata <span class="small">{{ $petugas->nama }}</span></h2>
                </div>
                <div class="col-md-2">
                    <div class="pull-right">
                        <a href="{{ url()->previous() }}" class="btn btn-dark">Kembali</a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                    <div class="profile_img">
                        <div id="crop-avatar">
                            <!-- Current avatar -->
                            <img class="img-responsive avatar-view" src="{{ asset('img/avatar') .'/'. getPicture($petugas->user->avatar) }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <table class="table">
                        <tr>
                            <th>Nama</th>
                            <td>{{ $petugas->nama }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $petugas->alamat }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $petugas->user->email }}</td>
                        </tr>
                        <tr>
                            <th>Kontak</th>
                            <td>{{ $petugas->kontak }}</td>
                        </tr>
                        <tr>
                            <th>Jenis kelamin</th>
                            <td>{{ $petugas->jk }}</td>
                        </tr>
                        <tr>
                            <th>Agama </th>
                            <td>{{ $petugas->agama }}</td>
                        </tr>
                        <tr>
                            <th>Mendaftar pada</th>
                            <td>{{ $petugas->created_at }}</td>
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