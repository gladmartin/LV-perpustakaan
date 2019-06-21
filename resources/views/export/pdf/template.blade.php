<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Export Petugas</title>
    <style>
        body {
            font-size: 12px;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td><img src="{{ public_path('img') . "/" . identitas()->logo }}" width="100"></td>
            <td>
                <h2 align="center"> {{ identitas()->nama }} <br> {{ identitas()->alamat }}  </h2><h3 align="center">{{ identitas()->telp }} | {{ identitas()->email }}</h3>
            </td>
        </tr>
    </table>
    <hr>
    @yield('content')
</body>
</html>