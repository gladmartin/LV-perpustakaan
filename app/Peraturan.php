<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peraturan extends Model
{
    protected $table = 'peraturan';
    protected $fillable = ['lama_pengembalian', 'maksimal_peminjaman', 'dispensasi_keterlambatan', 'denda_keterlambatan', 'status'];
    
    public function pinjam()
    {
        return $this->hasMany('App\Pinjam');
    }

    public function petugas()
    {
        return $this->belongsTo('App\Petugas');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }
    public function scopeNonActive($query)
    {
        return $query->where('status', 'non-aktif');
    }
}
