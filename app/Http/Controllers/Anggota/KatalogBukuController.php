<?php

namespace App\Http\Controllers\Anggota;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Buku;

class KatalogBukuController extends Controller
{
    public function index()
    {
        $data['buku'] = Buku::all();
        return view('buku.katalog', $data);
    }
}
