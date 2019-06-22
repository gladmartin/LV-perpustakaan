<?php

namespace App\Imports;

use App\User;
use App\Petugas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class PetugasImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    /* public function collection(Collection $rows)
    {
        Validator::make($rows->toArray(), [
            'email' => 'required',
        ])->validate();

        foreach ($rows as $row) 
        {
            $user = new User;
            $user->name = $row['nama'];
            $user->email = $row['email'];
            $user->role = 'petugas';
            $user->password = bcrypt('123456789');
            $user->save();
            Petugas::create([
                'user_id' => $user->id,
                'nama' => $row['nama'],
                'kontak' => $row['kontak'],
                'jk' => $row['jenis_kelamin'],
                'agama' => $row['agama'],
                'alamat' => $row['alamat'],
            ]);
        }
    } */

    public function model(array $row)
    {
        $user = new User;
        $user->name = $row['nama'];
        $user->email = $row['email'];
        $user->role = 'petugas';
        $user->password = bcrypt('123456789');
        $user->save();
        return new Petugas([
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
