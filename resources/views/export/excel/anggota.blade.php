<table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jenis kelamin</th>
                <th>Agama</th>
                <th>Email</th>
                <th>No Hp</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($anggota as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jk }}</td>
                    <td>{{ $item->agama }}</td>
                    <td>{{ $item->user->email}}</td>
                    <td>{{ $item->kontak }}</td>
                    <td>{{ $item->alamat }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>