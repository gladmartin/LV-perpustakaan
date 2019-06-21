<?php

namespace App\Http\Controllers\Anggota;

use Illuminate\Http\Request;
use App\Pinjam;
use App\Buku;
use App\Http\Controllers\Controller;
use DataTables;

class PinjamController extends Controller
{
    public function json()
    {
        return DataTables::of(Pinjam::PinjamanSaya()->latest('tgl_pinjam')->get())
        ->addColumn('buku', function(Pinjam $pinjam) {
            $return = '';
            foreach ($pinjam->detailPinjam as $value) {
                $buku = Buku::find($value->buku_id);
                $return .= "<p><a class='badge' href='" .route('buku.show',$buku->id). "'>{$buku->judul}</a></p> "; 
            }
            return $return;
        })
        ->addColumn('petugas', function(Pinjam $pinjam) {
            return "<a class='text-green' href='". route('petugas.show', $pinjam->petugas->id) ."'>{$pinjam->petugas->nama}</a>";
        })
        ->addColumn('opsi', function(Pinjam $pinjam) {
            return "
            <a title='detail' href='". route('pinjam.show', $pinjam->id) ."' class='btn btn-dark' data-id='$pinjam->id'><i class='fa fa-eye'></i> </a>";
        })
        ->rawColumns(['opsi', 'petugas', 'buku'])
        ->make(true);
    }

    public function index()
    {
        return view('pinjam.list-pinjam-anggota');
    }
}
