@extends('layouts.master')

@section('title', 'Data buku')

@section('styles')
<link href="{{ asset('admin/assets/') }}/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('admin/assets/') }}/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">

@endsection

@section('title.left')
<h3>Data Buku</h3>
@stop

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="row x_title">
                <div class="col-md-6 col-xs-6">
                    <a href="{{ route('buku.create') }}" class="btn btn-dark btn-sm"><i class="fa fa-plus-square-o"></i> Tambah data</a> 
                </div>
               {{--  <div class="col-md-6 col-xs-6 text-right">
                    <div class="pull-right">
                        <a href="{{ route('export-pdf', 'anggota') }}" class="btn btn-dark btn-sm"><i class="fa fa-file-pdf-o"></i> Export ke PDF</a>
                        <a href="{{ route('export-excel', 'anggota') }}" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i> Export ke Excel</a> 
                    </div>
                </div> --}}
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="datatable-server-side" class="table table-striped table-bordered dt-responsive ">
                    <thead>
                        <tr>
                            <th>ISBN</th>
                            <th>Judul</th>
                            <th>Pengarang</th>
                            <th>Penerbit</th>
                            <th>Kategori</th>
                            <th>Rak</th>
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
        ajax: siteUrl('buku/json'),
        columns: [
            { data: 'isbn', name: 'isbn', orderable:false },
            { data: 'judul', name: 'judul' },
            { data: 'pengarang', name: 'pengarang' },
            { data: 'penerbit', name: 'penerbit' },
            { data: 'kategori', name: 'kategori' },
            { data: 'rak', name: 'rak' },
            { data: 'gambar', name: 'gambar', searchable: false, orderable: false },
            { data: 'opsi', name: 'opsi', searchable: false, orderable: false },
        ]
    });

    elementTable.on('click', '.hapus-buku' ,function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let url = `buku/${id}`;
        let ini = $(this);
        alertify.confirm('Konfirmasi',"Yakin ingin menghapus data ini?",
        function(){
            hapusData(url, ini);
        }, function() {
        });
    })


</script>

@endsection
