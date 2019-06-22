@extends('layouts.master')

@section('title', 'Data anggota')

@section('styles')
<link href="{{ asset('admin/assets/') }}/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('admin/assets/') }}/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">

@endsection

@section('title.left')
<h3>Data anggota</h3>
@stop

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="row x_title">
                <div class="col-md-8 col-xs-5">
                    <a href="#" data-toggle='modal' data-target='.bs-example-modal-lg' class="btn btn-success btn-sm">Import file Excel</a> 
                </div>
                <div class="col-md-4">
                    <div class="pull-right">
                        <a href="{{ url('anggota/export-excel') }}" class="btn btn-success btn-sm">Export ke Excel</a> 
                        <a href="{{ url('anggota/export-pdf') }}" class="btn btn-dark btn-sm">Export ke PDF</a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="datatable-server-side" class="table table-striped table-bordered dt-responsive nowrap"
                    cellspacing="0" width="100%">
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

<!-- modal -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" id="form-tambah" action="{{ url('petugas/import-excel') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="id">
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Import data petugas</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="petugas_excel">File Excel <span class="text-danger">*</span> </label>
                        <input id="petugas_excel" type="file" name="petugas_excel"  class="form-control">
                    </div>
                    <div class="errors"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-dark">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /modals -->


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
        ajax: siteUrl('anggota/json'),
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

    elementTable.on('click', '.hapus-anggota' ,function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let url = `anggota/${id}`;
        let ini = $(this);
        alertify.confirm('Konfirmasi',"Yakin ingin menghapus data ini?",
        function(){
            hapusData(url, ini);
        }, function() {
        });
    })

    $('.modal #form-tambah').on('submit', async function(e) {
        e.preventDefault();
        $('#form-tambah button[type=submit]').addClass('disabled');
        $('#form-tambah button[type=submit]').html('Memproses...');
        let data = new FormData(this);
        let url = siteUrl('petugas/import-excel');
        // kirim
        let response = await sendAxios(data, url, 'POST');
        // selesai
        $('#form-tambah button[type=submit]').removeClass('disabled');
        $('#form-tambah button[type=submit]').html('Import');
        let petugasExcel = $('#form-tambah #petugas_excel');
        clearErrorInput(petugasExcel);
        if (!response.data.status) {
            if (response.data.msg == 'form error') {
                let input = $('#form-tambah #petugas_excel');
                input.addClass('parsley-error');
                input.after(`<b class="text-danger errorInput">${response.data.errors}</b>`);
                return;
            }
            if (response.data.msg == 'format error') {
                const {errors} = response.data;
                let modalBody = $('.modal .modal-body .errors');
                let txt = `
                    <b class="text-danger">Opps.. Terjadi kesalahan</b>
                `;
                $.each(errors, function(i, e) {
                    txt += `<div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                        </button>Error pada kolom ${e.attribute}, baris ke-${e.row} => ${e.errors[0]}
                    </div>`
                });
                modalBody.html(txt);
                return;
            }
        }
        $('.modal').modal('hide');
        initNotify('Data berhasil dimport');
        table.ajax.reload();
    })
</script>
@endsection
