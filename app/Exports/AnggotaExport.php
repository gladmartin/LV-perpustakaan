<?php

namespace App\Exports;

use App\Anggota;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class AnggotaExport implements FromView
{ 
    public function view(): View
    {
        return view('export.excel.anggota', [
            'anggota' => Anggota::all()
        ]);
    }
}
