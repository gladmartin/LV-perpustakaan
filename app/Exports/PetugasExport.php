<?php

namespace App\Exports;

use App\Petugas;
use Maatwebsite\Excel\Concerns\FromCollection;

class PetugasExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Petugas::all();
    }
}
