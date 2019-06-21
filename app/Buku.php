<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Scope\LatestScope;

class Buku extends Model
{
    protected $table = 'buku';

    protected $fillable = ['isbn', 'rak_id', 'judul', 'pengarang_id', 'penerbit_id', 'cover', 'stok', 'tahun_terbit', 'kategori_id', 'deskripsi'];

    /* protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new LatestScope);
    } */

    public function rak()
    {
        return $this->belongsTo('App\Rak');
    }

    public function kategori()
    {
        return $this->belongsTo('App\Kategori');
    }

    public function pengarang()
    {
        return $this->belongsTo('App\Pengarang');
    }

    public function penerbit()
    {
        return $this->belongsTo('App\Penerbit');
    }

    public function getCover()
    {
        return !$this->cover ? 'no-pict.png' : $this->cover;
    }
}
