@extends('layouts.master')

@section('title', 'Data peraturan')

@section('styles')
<link href="{{ asset('admin/assets/') }}/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('admin/assets/') }}/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css"
    rel="stylesheet">

@endsection

@section('title.left')
<h3>Peraturan</h3>
@stop

@section('content')

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="row x_title">
                <div class="col-md-10 col-xs-8">
                    <h2>Peraturan peminjaman</h2>
                </div>
                <div class="col-md-2">
                    <div class="pull-right">
                        <a href="#" data-toggle='modal' data-target='.bs-example-modal-lg' class="btn btn-dark">Buat peraturan baru</a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="datatable-server-side" class="table table-striped table-bordered dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Pembuat peraturan</th>
                            <th>Lama pengembalian</th>
                            <th>Maksimal peminjaman</th>
                            <th>Dispensasi</th>
                            <th>Biaya denda</th>
                            <th>Status</th>
                            <th>Opsi</th>
                        </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Small modal -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form method="post" id="form-tambah" action="">
                @csrf
                <input type="hidden" id="id">
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Buat peraturan baru</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="lama_pengembalian">Lama pengembalian (hari) <span class="text-danger">*</span> </label>
                            <input id="lama_pengembalian" type="number" name="lama_pengembalian" required
                                class="form-control">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="maks">Maksimal peminjaman (buku) <span class="text-danger">*</span> </label>
                            <input id="maks" type="number" name="maks" required
                                class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="dispensasi">Dispensasi keterlambatan (hari) <span class="text-danger">*</span> </label>
                            <input id="dispensasi" type="number" name="dispensasi"                        class="form-control">
                            <span class="small">Kosongkan jika tidak ingin ada Dispensasi</span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="denda">Biaya denda (Rp)<span class="text-danger">*</span> </label>
                            <input id="denda" type="number" name="denda" required
                                class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-dark">Simpan</button>
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
        ajax: siteUrl('administrator/peraturan/json'),
        columns: [{
                data: 'id',
                name: 'id',
                searchable: false,
                orderable: false
            },
            {
                data: 'petugas',
                name: 'petugas'
            },
            {
                data: 'lama_pengembalian',
                name: 'lama_pengembalian'
            },
            {
                data: 'maksimal_peminjaman',
                name: 'maksimal_peminjaman'
            },
            {
                data: 'dispensasi_keterlambatan',
                name: 'dispensasi_keterlambatan'
            },
            {
                data: 'biaya_denda',
                name: 'biaya_denda'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'opsi',
                name: 'opsi',
                searchable: false,
                orderable: false
            },
        ]
    });

    elementTable.on('click', '.hapus-peraturan', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        let url = `administrator/peraturan/${id}`;
        let ini = $(this);
        alertify.confirm('Konfirmasi', "Yakin ingin menghapus data ini?",
            function () {
                hapusData(url, ini);
            },
            function () {});
    })

    $('#form-tambah').on('submit', async function(e) {
        e.preventDefault();
        $('#form-tambah button[type=submit]').addClass('disabled');
        $('#form-tambah button[type=submit]').html('Memproses...');
        let data = new FormData(this);
        let url = siteUrl(`administrator/peraturan/`);
        // kirim
        let response = await sendAxios(data, url, 'POST');
        // selesai
        $('#form-tambah button[type=submit]').removeClass('disabled');
        $('#form-tambah button[type=submit]').html('Tambah');
        let elPengembalian = $('#form-tambah #lama_pengembalian');
        let elMaks = $('#form-tambah #maks');
        let elDispensasi = $('#form-tambah #dispensasi');
        let elDenda = $('#form-tambah #denda');
        clearErrorInput([elPengembalian,elMaks,elDispensasi,elDenda]);
        if (!response.data.status) {
            $.each(response.data.errors, function(i, el) {
                let tes = $(`#form-tambah #${i}`);
               tes.addClass('parsley-error');
                $(`#form-tambah #${i}`).after(`<b class="text-danger errorInput">${el[0]}</b>`);
            })
            return;
        }
        elNama.val('');
        initNotify('Data berhasil ditambah');
        table.ajax.reload();
    })

</script>
@endsection
