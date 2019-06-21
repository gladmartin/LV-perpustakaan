@extends('layouts.master')

@section('title', 'Daftar kategori')

@section('styles')
<link href="{{ asset('admin/assets/') }}/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
@endsection

@section('title.left')
<h3>Kategori</h3>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="x_panel">
            <div class="x_title">
                <h2>Daftar data<small>kategori</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="datatable-server-side" class="table table-striped table-bordered dataTable no-footer"
                                role="grid" aria-describedby="datatable_info">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama kategori</th>
                                        <th>Jumlah buku</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>                               
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-4">
        <div class="x_panel">
            <div class="x_title">
                <h2>Form tambah</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form action="{{ route('kategori.store') }}" id="form-tambah" method="post">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama kategori <span class="text-danger">*</span> </label>
                    <input id="nama" autocomplete="off" type="text" name="nama" required class="form-control">
                </div>
                <div class="form-group">
                    <button class="btn btn-dark" type="submit">Tambah</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Small modal -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="post" id="form-ubah" action="">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="id">
                    <div class="modal-header bg-green">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">Ubah data kategori</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama kategori <span class="text-danger">*</span> </label>
                            <input id="nama" autocomplete="off" type="text" name="nama" required class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-dark">Simpan perubahan</button>
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
<script src="{{ asset('js/axios.min.js') }}"></script>
<script>    
    
    let elementTable = $('#datatable-server-side');
    let table = elementTable.DataTable({
        processing: true,
        serverSide: true,
        ajax: siteUrl('kategori/json'),
        columns: [
            { data: 'id', name: 'id', searchable: false },
            { data: 'nama', name: 'nama' },
            { data: 'buku_count', name: 'buku_count' },
            { data: 'opsi', name: 'opsi', searchable: false, orderable: false },
        ]
    });

    elementTable.on('click', '.hapus-kategori' ,function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let url = `kategori/${id}`;
        let ini = $(this);
        alertify.confirm('Konfirmasi',"Yakin ingin menghapus data ini?",
        function(){
            hapusData(url, ini);
        }, function() {
        });
    })

    elementTable.on('click', '.ubah-kategori', async function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let url = siteUrl(`kategori/${id}`);
        let response = await sendAxios([], url);
        if (!response.data.status) return alert('Data tidak ditemukan');
        const {nama} = response.data.data;
        $('.modal #nama').val(nama);
        $('#id').val(id);
    })

    $('#form-tambah').on('submit', async function(e) {
        e.preventDefault();
        $('#form-tambah button').addClass('disabled');
        $('#form-tambah button').html('Memproses...');
        let data = new FormData(this);
        let url = siteUrl(`kategori/`);
        // kirim
        let response = await sendAxios(data, url, 'POST');
        // selesai
        $('#form-tambah button').removeClass('disabled');
        $('#form-tambah button').html('Tambah');
        let elNama = $('#form-tambah #nama');
        if (!response.data.status) {
            const {nama} = response.data.errors                
            clearErrorInput(elNama);
            if (nama) {
                elNama.addClass('parsley-error');
                elNama.after(`<b class="text-danger errorInput">${nama}</b>`);
            }
            return;
        }
        elNama.val('');
        clearErrorInput(elNama);
        initNotify('Data berhasil ditambah');
        table.ajax.reload();
    })

    $('#form-ubah').on('submit', async function(e) {
        e.preventDefault();
        $('#form-ubah button[type="submit"]').addClass('disabled');
        $('#form-ubah button[type="submit"]').html('Memproses...');        
        let id = $('#id').val();
        let url = siteUrl(`kategori/${id}`);
        let data = new FormData(this);
        // kirim
        let response = await sendAxios(data, url, 'POST');
        // selesai
        $('#form-ubah button[type="submit"]').removeClass('disabled');
        $('#form-ubah button[type="submit"]').html('Simpan perubahan');
        let elNama = $('#form-ubah #nama');
        if (!response.data.status) {
            const {nama} = response.data.errors                
            clearErrorInput(elNama);
            if (nama) {
                elNama.addClass('parsley-error');
                elNama.after(`<b class="text-danger errorInput">${nama}</b>`);
            }
            return;
        }
        $('.modal').modal('hide');
        elNama.val('');
        clearErrorInput(elNama);
        initNotify('Data berhasil diubah');
        table.ajax.reload();
    })

</script>
@endsection
