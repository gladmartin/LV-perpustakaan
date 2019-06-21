<?php

namespace App\Exports;

use App\Petugas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class PetugasExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Petugas::all();
    }

    public function view(): View
    {
        return view('export.excel.petugas', [
            'petugas' => Petugas::all()
        ]);
    }

    /**
    * @var Petugas $petugas
    */
    public function map($petugas): array
    {
        return [
            $petugas->nama,
            $petugas->jk,
            $petugas->agama,
            $petugas->user->email,
            $petugas->alamat,
        ];
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Jenis Kelamain',
            'Agama',
            'Email',
            'Alamat',
        ];
    }
}
