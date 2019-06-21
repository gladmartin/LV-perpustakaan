<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class petugas extends Model
{
    protected $table = 'petugas';
    protected $fillable = ['nama', 'jk', 'agama', 'alamat', 'user_id', 'kontak', 'agama'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
