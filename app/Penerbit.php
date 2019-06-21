<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penerbit extends Model
{
    protected $table = 'penerbit';
    protected $fillable = ['nama', 'gambar'];

    public function buku()
    {
        return $this->hasMany('App\Buku');
    }
}
