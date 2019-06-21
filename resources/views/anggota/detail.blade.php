@extends('layouts.master')

@section('title')
Detail anggota {{ $anggota->nama }}
@stop

@section('styles')

@endsection

@section('title.left')
<h3>Detail data anggota</h3>
@stop


@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="row x_title">
                <div class="col-md-10 col-xs-8">
                    <h2>Biodata <small>{{ $anggota->nama }}</small></h2>
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
                            <img class="img-responsive avatar-view" src="{{ asset('img/avatar') .'/'. getPicture($anggota->user->avatar) }}">
                        </div>
                    </div>
                    <h3>{{ $anggota->nama }}</h3>

                    <ul class="list-unstyled user_data">
                        <li><i class="fa fa-map-marker user-profile-icon"></i> {{ $anggota->alamat }}</li>
                        <li>
                            <i class="fa fa-send user-profile-icon"></i> {{ $anggota->user->email }}
                        </li>
                        <li>
                            <i class="fa fa-phone user-profile-icon"></i> {{ $anggota->kontak }}
                        </li>
                        <li>
                            <i class="fa fa-user user-profile-icon"></i> {{ $anggota->jk }}
                        </li>
                    </ul>

                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">

                    <div class="profile_title">
                        <div class="col-md-6">
                            <h2>Aktifitas peminjaman anggota</h2>
                        </div>
                        <div class="col-md-6">
                            <div id="reportrange" class="pull-right"
                                style="margin-top: 5px; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #E6E9ED">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                            </div>
                        </div>
                    </div>
                    <!-- start of user-activity-graph -->
                    <div id="graph_bar" style="width:100%; height:280px;"></div>
                    <!-- end of user-activity-graph -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="row x_title">
                <h2>Detail peminjaman buku</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab"
                                data-toggle="tab" aria-expanded="true">Buku yang sedang dipinjam</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab"
                                data-toggle="tab" aria-expanded="false">Buku yang telah dikembalikan</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2"
                                data-toggle="tab" aria-expanded="false">Denda</a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1"
                            aria-labelledby="home-tab">
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>Buku</th>
                                    <th>Tanggal peminjaman</th>
                                </tr>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>Buku</th>
                                    <th>Tanggal peminjaman</th>
                                    <th>Tanggal pengembalian</th>
                                    <th>Petugas</th>
                                </tr>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                            <table class="table table-hover">
                                <tr>
                                    <th>#</th>
                                    <th>Buku</th>
                                    <th>Terlambat (hari)</th>
                                    <th>Total denda</th>
                                    <th>Status</th>
                                </tr>
                            </table>
                        </div>
                    </div>
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