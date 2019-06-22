<?php

namespace App\Exports;

use App\Petugas;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class PetugasExport implements FromView
{
    public function view(): View
    {
        return view('export.excel.petugas', [
            'petugas' => Petugas::all()
        ]);
    }
}
