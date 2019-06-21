@extends('export.pdf.template')

@section('content')
<h5>Data petugas</h5>
<table border="1" cellpadding="3" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jenis kelamin</th>
            <th>Agama</th>
            <th>Email</th>
            <th>No Hp</th>
            <th>Alamat</th>
            <th>Foto</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
        @endphp
        @foreach ($petugas as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->jk }}</td>
                <td>{{ $item->agama }}</td>
                <td>{{ $item->user->email}}</td>
                <td>{{ $item->kontak }}</td>
                <td>{{ $item->alamat }}</td>
                <td>
                    <img src="{{ public_path('img/avatar') . "/" . getPicture($item->user->avatar) }}" width="100">
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection