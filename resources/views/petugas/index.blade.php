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
                <div class="row x_title">
                    <div class="col-md-8 col-xs-5">
                        <h2>Data petugas</h2>
                    </div>
                    <div class="col-md-4">
                        <div class="pull-right">
                            <a href="{{ url('petugas/export-excel') }}" class="btn btn-success btn-sm">Export ke Excel</a> 
                            <a href="{{ url('petugas/export-pdf') }}" class="btn btn-dark btn-sm">Export ke PDF</a>
                        </div>
                    </div>
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
        ajax: siteUrl('petugas/json'),
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
        let url = `petugas/${id}`;
        let ini = $(this);
        alertify.confirm('Konfirmasi',"Yakin ingin menghapus data ini?",
        function(){
            hapusData(url, ini);
        }, function() {
        });
    })


</script>
@endsection
