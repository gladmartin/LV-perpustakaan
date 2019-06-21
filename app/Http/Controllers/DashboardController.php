<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anggota;
use App\Buku;
use App\petugas;
use App\Pinjam;

class DashboardController extends Controller
{
    public function index()
    {
        $data['jmlAnggota'] = Anggota::all()->count();
        $data['jmlBuku'] = Buku::all()->count();
        $data['jmlPetugas'] = Petugas::all()->count();
        $data['jmlPinjam'] = Pinjam::status('dipinjam')->count();
        return view('dashboard.index', $data);
    }
}
