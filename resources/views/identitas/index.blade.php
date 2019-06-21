@extends('layouts.master')

@section('title', 'Identitas Website')

@section('title.left')
<h3>Identitas Website</h3>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            {{-- <div class="x_title"> --}}
                {{-- <h2>Daftar data<small>kategori</small></h2> --}}
                {{-- <div class="clearfix"></div> --}}
            {{-- </div> --}}
            <div class="x_content">
                <table class="table table-borderd">
                    <tr>
                        <th>Nama perpustakaan</th>
                        <td id="1">{{ $identitas->nama }}</td>
                    </tr>
                    <tr>
                        <th>Email resmi </th>
                        <td id="2">{{ $identitas->email }}</td>
                    </tr>
                    <tr>
                        <th>Alamat </th>
                        <td id="3">{{ $identitas->alamat }}</td>
                    </tr>
                    <tr>
                        <th>Telpon </th>
                        <td id="4">{{ $identitas->telp }}</td>
                    </tr>
                    <tr>
                        <th>Logo perpustakaan </th>
                        <td id="5">
                            <img src="{{ asset('img') . '/' . getPicture($identitas->logo) }}" alt="Logo" class="thumbnail">
                        </td>
                    </tr>
                    <tr>
                        <th>Icon webiste </th>
                        <td id="6">
                            <img src="{{ asset('img') . '/' . getPicture($identitas->icon) }}" alt="Logo" width="50">
                        </td>
                    </tr>
                </table>
                <button class="btn btn-dark" data-toggle='modal' data-target='.bs-example-modal-lg'>Edit</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" id="form-ubah" action="" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="id">
                <div class="modal-header bg-green">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2">Ubah identitas web</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="nama_perpustakaan">Nama perpustakaan<span class="text-danger">*</span> </label>
                            <input id="nama_perpustakaan" type="text" name="nama_perpustakaan" required value="{{ $identitas->nama }}" class="form-control">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="email">Email website <span class="text-danger">*</span> </label>
                            <input id="email" type="email" name="email" required value="{{ $identitas->email }}" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="alamat">Alamat <span class="text-danger">*</span> </label>
                            <textarea id="alamat" name="alamat"                        class="form-control">{{ $identitas->alamat }}</textarea>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="telp">Telpon<span class="text-danger">*</span> </label>
                            <input id="telp" type="text" name="telp" required
                                class="form-control" value="{{ $identitas->telp }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="logo">Logo perpustakaan</label>
                            <input id="logo" class="form-control" type="file" name="logo">
                            <span class="small">Kosongkan jika tidak ingin merubah</span>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="icon">Icon website</label>
                            <input id="icon" class="form-control" type="file" name="icon">
                            <span class="small">Kosongkan jika tidak ingin merubah</span>
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

@endsection

@section('scripts')
    <script>
        $('#form-ubah').on('submit', async function(e) {
            e.preventDefault();
            $('#form-ubah button[type=submit]').addClass('disabled');
            $('#form-ubah button[type=submit]').html('Memproses...');
            let data = new FormData(this);
            let url = siteUrl(`identitas-web/`);
            // kirim
            let response = await sendAxios(data, url, 'POST');
            // selesai
            $('#form-ubah button[type=submit]').removeClass('disabled');
            $('#form-ubah button[type=submit]').html('Simpan');
            let elNamaPerpus = $('#form-ubah #nama_perpustakaan');
            let elEmail = $('#form-ubah #email');
            let elAlamat = $('#form-ubah #alamat');
            let elTelp = $('#form-ubah #telp');
            let elLogo = $('#form-ubah #logo');
            let elIcon = $('#form-ubah #icon');
            clearErrorInput([elNamaPerpus,elEmail,elAlamat,elTelp]);
            if (!response.data.status) {
                $.each(response.data.errors, function(i, el) {
                    let tes = $(`#form-ubah #${i}`);
                    tes.addClass('parsley-error');
                    $(`#form-ubah #${i}`).after(`<b class="text-danger errorInput">${el[0]}</b>`);
                })
                return;
            }
            $('.modal').modal('hide');
            const {nama, email, alamat, telp, logo, icon} = response.data.data;
            $('#1').html(nama);
            $('#2').html(email);
            $('#3').html(alamat);
            $('#4').html(telp);
            $('#5 img').attr('src', `../img/${logo}`);
            $('#6 img').attr('src', `../img/${icon}`);
            initNotify('Data berhasil diubah');
        })
    </script>
@endsection