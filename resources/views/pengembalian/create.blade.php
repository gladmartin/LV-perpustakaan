@extends('layouts.master')

@section('title', 'Input pengembalian buku')

@section('styles')
@endsection

@section('title.left')
<h3>Input pengembalian buku</h3>
@stop

@section('content')

<div class="row">
    <form action="{{ route('pinjam.store') }}" method="POST">
        <input type="hidden" name="buku" id="buku">
        <input type="hidden" name="pinjam_id" id="pinjam-id">
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
                        <select name="anggota_id" id="anggota_id" class="form-control select2">
                            <option value=""></option>
                            @foreach ($anggota as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('anggota'))
                        <span class="text-danger">{{ $errors->first('anggota') }}</span>
                        @endif
                    </div>        
                    <div class="form-group">
                        <label for="tgl">Tanggal pengembalian</label>
                        <input type="text" disabled value="{{ now() }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tgl">Tanggal peminjaman</label>
                        <input type="text" disabled id="tgl_pinjam" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Detail<small>pengembalian</small></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Judul</td>
                                <th>Pengarang</td>
                                <th>Cover</td>
                                <th width=120px>Keterangan</td>
                            </tr>
                            <tbody class="tbody">
                                <tr>
                                    <td colspan="4" align="center">Silahkan pilih anggota, untuk memunculkan list buku yang dipinjam</td>
                                </tr>
                            </tbody>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-12">
                            <button type="submit" class="btn btn-dark">Proses pengembalian</button>
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
        
        let valBuku = [];
        $('#anggota_id').on('change', async function(e) {
            e.preventDefault();
            valBuku = [];
            let id = $(this).val();
            let url = siteUrl(`pinjam/getbyanggotaid/${id}`);
            let response = await sendAxios([], url);
            if (!response.data.status) {
                valBuku = [];
                $('.tbody').html('');
                alertify.alert('Info',response.data.msg,
                    function(){}
                );
                return;
            }
            const {buku, pengarang, pinjam} = response.data.data;
            
            $('#tgl_pinjam').val(pinjam.tgl_pinjam);
            let table = '';
            $.each(buku, function(i, el) {
                table += `
                    <tr>
                    <td>${el.judul}</td>
                    <td>${el.pengarang}</td>
                    <td><img src='${el.cover}' width='100px'></td>
                    <td>
                        <select class='form-control select-keterangan' data-id='${el.id}'>
                            <option value='ada'>Ada</option>
                            <option value='hilang'>Hilang</option>
                        </select>
                    </td>
                    </tr>
                `;
                valBuku.push({id:el.id,keterangan:'ada'});
            });
            $('#pinjam-id').val(pinjam.id);
            $('#buku').val(JSON.stringify(valBuku));
            $('.tbody').html(table);
        })

        $('table').on('change', '.select-keterangan', function() {
            let id = $(this).data('id');
            let valKeterangan = $(this).val();
            objIndex = valBuku.findIndex((obj => obj.id == id));
            valBuku[objIndex].keterangan = valKeterangan;
            $('#buku').val(JSON.stringify(valBuku));
        })
        
        let arrBuku = [];


        $('form').on('submit' , async function(e) {
            e.preventDefault();
            let btnSubmit = $('form button[type=submit]');
            btnSubmit.addClass('disabled');
            btnSubmit.html('Mohon tunggu....');
            let data = new FormData(this);
            let url =  siteUrl('pengembalian');
            let response = await sendAxios(data, url, 'POST');
            btnSubmit.removeClass('disabled');
            btnSubmit.html('Proses pengembalian');
            if(!response.data.status) return initNotify(JSON.stringify(response.data.errors), 'error', 'red', 'Error');
            openWin(response.data);
        })
        function openWin(res) {
            let params = [
                `height = ${screen.height}`,
                `width = ${screen.width}`,
                `fullscreen = yes`
            ].join(',');
            let html = `
            <html>
                <head>
                    <style>
                        body {
                            font-family: arials, Merchant Copy;
                            padding:30px;
                        }
                        .wrapper {
                            width: 280px !important;
                            border: 1px solid black;
                            padding: 10px;
                        }
                        @page {
                            size: auto;
                            margin: 0mm;
                        }
                    </style>
                </head>
                <body>
                    <div class="wrapper">
                    <p style="text-align:center; margin-top:0"><b style='font-size:30px'>${res.data.perpustakaan.nama}</b><br>
                    ${res.data.perpustakaan.alamat}<br>
                    <b>Pengembalian buku</b></p>
                    <table cellspacing=0 cellpadding=0 width=100%>
                        <tr>
                            <td>Nama anggota</td>
                            <td> : ${res.data.anggota}</td>
                        </tr>
                        <tr>
                            <td>Tanggal pinjam</td>
                            <td> : ${res.data.tglPinjam}</td>
                        </tr>
                        <tr>
                            <td>Tanggal kembali</td>
                            <td> : ${res.data.tglKembali}</td>
                        </tr>
                        <tr>
                            <td>Jumlah pengembalian</td>
                            <td> : ${res.data.jmlPengembalian} buku</td>
                        </tr>
                    </table>
                    </br>
                    <p style="margin:0;text-decoration:underline;margin-bottom:2px">List pengembalian</p>
                    <table cellspacing=0 border=1 width=100%>
                        <tr>
                            <td>Buku</td>
                            <td>Ket</td>
                        </tr>`;
                        $.each(res.data.buku, function(i, e) {
                        html += `<tr>
                                    <td>${e.judul}</td>
                                    <td>${e.ket}</td>
                                </tr>`;
                        })    
            html += `</table>
                    </br>
                    <u>Denda</u>`;
                    if (res.data.denda) {
                        const {keterlambatan, maks, biayaDenda,grandtotalketerlambatan} = res.data.denda;
                        html += `
                            <table cellspacing=0 width=100%>
                                <tr>
                                    <td>Keterlambatan</td>
                                    <td> : ${keterlambatan} hari</td>
                                </tr>
                                <tr>
                                    <td>Biaya keterlambatan /hari</td>
                                    <td> : Rp ${biayaDenda}</td>
                                </tr>
                                <tr>
                                    <td>Maks. Lama pengembalian</td>
                                    <td> : ${maks} hari</td>
                                </tr>
                                <tr>
                                    <td>${keterlambatan} x ${biayaDenda} x ${res.data.jmlPengembalian}</td>
                                    <td> : Rp ${grandtotalketerlambatan}</td>
                                </tr>
                                <tr>
                                    <td colspan=2><small><i>* keterlambatan x biaya x jml pinjam</i></small></td>
                                </tr>
                            </table>
                        `;
                    } else {
                        html += `<br> -`;
                    }
            html += `
            <br><small><center>Buku adalah jendela dunia, <br>terimakasih atas kunjungan anda!</center></small>
            </div>
            </body>
            </html>
            `;
            myWindow = window.open('', 'Print pengembalian', params);
            myWindow.moveTo(0,0);
            myWindow.document.write(html);
            myWindow.document.close();
            myWindow.focus();
            myWindow.print();
        }
    </script>
@endsection