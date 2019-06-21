<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pinjam extends Model
{
    protected $table = 'pinjam';

    public $timestamps = false;

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
    
    public function scopePinjamanSaya($query)
    {
        $userId = auth()->user()->id;
        $anggotaId = anggota($userId)->id;
        return $query->where('anggota_id', $anggotaId);
    }

    public function scopeGetByAnggotaId($query, $id)
    {
        return $query->where('anggota_id', $id);
    }

    public function anggota()
    {
        return $this->belongsTo('App\Anggota');
    }

    public function petugas()
    {
        return $this->belongsTo('App\Petugas');
    }

    public function peraturan()
    {
        return $this->belongsTo('App\Peraturan');
    }

    public function detailPinjam()
    {
        return $this->hasMany('App\DetailPinjam');
    }
}
