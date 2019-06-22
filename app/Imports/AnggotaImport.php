<?php

namespace App\Imports;

use App\User;
use App\Anggota;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;

class AnggotaImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    public function model(array $row)
    {
        $user = new User;
        $user->name = $row['nama'];
        $user->email = $row['email'];
        $user->role = 'anggota';
        $user->password = bcrypt('123456789');
        $user->save();
        return new Anggota([
            'user_id' => $user->id,
            'nama' => $row['nama'],
            'kontak' => $row['kontak'],
            'jk' => $row['jenis_kelamin'],
            'agama' => $row['agama'],
            'alamat' => $row['alamat'],
        ]);
    }

    public function rules(): array
    {
        return [
            'nama' => 'required',
            'email' => 'required|email|unique:users',
            'kontak' => 'required',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'alamat' => 'required',
        ];
    }

    public function headingRow(): int
    {
        return 4;
    }
}
