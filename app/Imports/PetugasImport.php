<?php

namespace App\Imports;

use App\Petugas;
use Maatwebsite\Excel\Concerns\ToModel;

class PetugasImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Petugas([
            'user_id' => $row[0],
            'nama' => $row[1],
            'kontak' => $row[2],
            'jk' => $row[3],
            'agama' => $row[4],
            'alamat' => $row[5],
        ]);
    }
}
