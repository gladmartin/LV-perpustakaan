@extends('layouts.master')

@section('title', 'Data petugas')

@section('styles')
<link href="{{ asset('admin/assets/') }}/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('admin/assets/') }}/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">

@endsection

@section('title.left')
<h3>Petugas</h3>
@stop

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Daftar data<small>petugas</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                            aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Settings 1</a>
                            </li>
                            <li><a href="#">Settings 2</a>
                            </li>
                        </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="datatable-server-side" class="table table-striped table-bordered dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Kontak</th>
                            <th>Jenis kelamin</th>
                            <th>Agama</th>
                            <th>Alamat</th> 
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script src="{{ asset('admin/assets') }}/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('admin/assets') }}/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="{{ asset('admin/assets') }}/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('admin/assets') }}/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script>
    let elementTable = $('#datatable-server-side');
    let table = elementTable.DataTable({
        processing: true,
        serverSide: true,
        ajax: siteUrl('administrator/petugas/json'),
        columns: [
            { data: 'nama', name: 'nama' },
            { data: 'email', name: 'email' },
            { data: 'kontak', name: 'kontak' },
            { data: 'jk', name: 'jk' },
            { data: 'agama', name: 'agama' },
            { data: 'alamat', name: 'alamat' },
            { data: 'gambar', name: 'gambar', searchable: false, orderable: false },
            { data: 'opsi', name: 'opsi', searchable: false, orderable: false },
        ]
    });

    elementTable.on('click', '.hapus-petugas' ,function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let url = `administrator/petugas/${id}`;
        let ini = $(this);
        alertify.confirm('Konfirmasi',"Yakin ingin menghapus data ini?",
        function(){
            hapusData(url, ini);
        }, function() {
        });
    })


</script>
@endsection
