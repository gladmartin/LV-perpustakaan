<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPinjam extends Model
{
    protected $table = 'detail_pinjam';

    public $timestamps = false;

    public function pinjam()
    {
        $this->belongsTo('App\Pinjam');
    }

    public function buku()
    {
        return $this->belongsTo('App\Buku');
    }
}
