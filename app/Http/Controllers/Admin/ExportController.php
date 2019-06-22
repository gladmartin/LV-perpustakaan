<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Anggota;
use App\Petugas;
use PDF;
use App\Exports\AnggotaExport;
use App\Exports\PetugasExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function pdf($table)
    {
        switch ($table) {
            case 'anggota':
                $data['anggota'] = Anggota::with('user')->get();
                $fileName = 'daftar-data-anggota.pdf';
                $pdf = PDF::loadView('export.pdf.anggota', $data);
            break;
            
            case 'petugas':
                $data['petugas'] = Petugas::with('user')->get();
                $fileName = 'daftar-data-petugas.pdf';
                $pdf = PDF::loadView('export.pdf.petugas', $data);
            break;
            
            default:
                abort(404);
            break;
        }

        return $pdf->download($fileName);
    }

    public function excel($table)
    {
        switch ($table) {
            case 'anggota':
                return Excel::download(new AnggotaExport, 'daftar-data-anggota.xlsx');
            break;
            case 'petugas':
                return Excel::download(new PetugasExport, 'daftar-data-petugas.xlsx');
            break;
            
            default:
                abort(404);
                break;
        }
    }
}
