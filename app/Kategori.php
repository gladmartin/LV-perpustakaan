<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $fillable = ['nama', 'slug'];

    public function buku()
    {
        return $this->hasMany('App\Buku');
    }
}
