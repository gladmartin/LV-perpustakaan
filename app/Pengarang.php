<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengarang extends Model
{
    protected $table = 'pengarang';
    protected $fillable = ['nama', 'gambar'];
    
    public function buku()
    {
        return $this->hasMany('App\Buku');
    }
}
