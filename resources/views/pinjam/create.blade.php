@extends('layouts.master')

@section('title', 'Input peminjaman buku')

@section('styles')
@endsection

@section('title.left')
<h3>Input peminjaman buku</h3>
@stop

@section('content')

<div class="row">
    <form action="{{ route('pinjam.store') }}" method="POST">
        <input type="hidden" name="buku" id="buku">
        @csrf
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Data<small>anggota</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="form-group">
                        <label for="anggota">Anggota <span class="required">*</span>
                        </label>
                        <select name="anggota" id="anggota" class="form-control select2">
                            @foreach ($anggota as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('anggota'))
                        <span class="text-danger">{{ $errors->first('anggota') }}</span>
                        @endif
                    </div>        
                    <div class="form-group">
                        <label for="tgl">Tanggal Peminjaman</label>
                        <input type="text" disabled value="{{ now() }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tgl">Tanggal jatuh tempo</label>
                        <input type="text" disabled value="{{ now()->addDays($peraturan->lama_pengembalian) }}" class="form-control">
                        <span class="small">{{ $peraturan->lama_pengembalian }} hari dari sekarang.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Data<small>buku</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="form-group col-md-12 col-xs-12">
                            <label for="pil-buku">Buku</label>
                            <select id="pil-buku" class="form-control select2">
                                <option value=""></option>
                                @foreach ($buku as $item)
                                <option value="{{ $item->id }}">[{{ $item->pengarang->nama }}] {{ $item->judul }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Detail<small>peminjaman</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Kategori</th>
                                <th>Cover</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-12">
                            <button type="submit" class="btn btn-dark">Proses peminjaman</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('scripts')
    <script>
        $('.select2').select2({
            placeholder: '-- Pilih option--'
        });
        
        let arrBuku = [];
        $('#pil-buku').on('change', async function(e) {
            e.preventDefault();
            let bukuId = parseInt($(this).val());
            let anggotaId = parseInt($('#anggota').val());
            if (!bukuId) return initNotify('Pilih buku yang ingin dipinjam');
            if (arrBuku.includes(bukuId)) return initNotify('Buku sudah di pilih');
            let url = siteUrl(`pinjam/get-buku/${bukuId}/${anggotaId}`);
            // $(this).addClass('disabled');
            // $(this).html('Memproses..');
            let response = await sendAxios([], url);
            if (!response.data.status) return initNotify('Maaf!, buku tidak ditemukan lagi');
            // console.log(response);
            const {judul, pengarang, penerbit, kategori, cover} = response.data.data;
            let table = `
            <tr>
                <td>${judul}</td>
                <td>${pengarang}</td>
                <td>${penerbit}</td>
                <td>${kategori}</td>
                <td><img src='${cover}' width='100px'></td>
                <td>
                    <a class='btn btn-danger hapus-item' data-id='${bukuId}' title='hapus'><i class='fa fa-trash'></i></a>
                </td>
            </tr>
            `;
            arrBuku.push(bukuId);
            $('#buku').val(JSON.stringify(arrBuku));
            $('table tbody').append(table);
            // $(this).removeClass('disabled');
            // $(this).html('Tambah');
        })

        $('table').on('click', '.hapus-item', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $(this).parent().parent().remove();
            arrBuku = arrBuku.filter(e => e != id);
            // arrBuku.pop(id);
            $('#buku').val(JSON.stringify(arrBuku));
        })

        $('form').on('submit' , async function(e) {
            e.preventDefault();
            let btnSubmit = $('form button[type=submit]');
            btnSubmit.addClass('disabled');
            btnSubmit.html('Mohon tunggu....');
            let data = new FormData(this);
            let url =  siteUrl('pinjam');
            let response = await sendAxios(data, url, 'POST');
            btnSubmit.removeClass('disabled');
            btnSubmit.html('Proses peminjaman');
            if(response.data.errors == 'maks peminjaman') {
                const {anggota, anggotaId,dipinjam, maksimal, pinjaman} = response.data.data;
                let selesih = maksimal - pinjaman;
                let pesan = `<b>${anggota}</b> telah melebihi maksimal peminjaman buku
                <br><br>
                <table class='table'>
                    <tr>
                        <th>Peraturan maksimal peminjaman</th>
                        <td>${maksimal} (buku)</td>
                    </tr>
                    <tr>
                        <th>Yang dipinjam</th>
                        <td>${dipinjam} (buku)</td>
                    </tr>`
                if(pinjaman > 0) {
                pesan +=`
                    <tr>
                        <th>Yang belum dikembalikan</th>
                        <td>${pinjaman} (buku)</td>
                    </tr>
                    <tr>
                        <th>Pinjaman yang diperbolehkan</th>
                        <td>${selesih} (buku)</td>
                    </tr>`
                }
                pesan +=`
                </table>
                <span class='small'>
                    Lihat detail peminjaman <a target='_blank' href='../anggota/${anggotaId}'>${anggota}</a><br>
                    Untuk melihat peraturan, silahkan klik <a target='_blank' href='../peraturan'>disini</a>
                </span>
                `;
                return alertify.alert('Info',pesan,
                    function(){
                        
                    }
                );
            }
            if(!response.data.status) return initNotify(JSON.stringify(response.data.errors), 'error', 'red', 'Error');
            document.location.href = siteUrl('pinjam');
        })
    </script>
@endsection