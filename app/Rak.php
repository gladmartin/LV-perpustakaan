<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    protected $table = 'rak';
    protected $fillable = ['nama'];

    public function buku()
    {
        return $this->hasMany('App\Buku');
    }
}
