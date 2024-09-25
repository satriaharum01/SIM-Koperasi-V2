<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;
    protected $table = 'pinjaman';
    protected $primaryKey = 'id_pinjam';
    protected $fillable = ['id_user','tenor','jumlah','status','keterangan','created_at'];

    public function cari_user()
    {
        return $this->belongsTo('App\Models\User', 'id_user', 'id')->withDefault([
            'name' => 'Tanpa Nama',
            'email' => 'Tidak Ada',
            'level' => 'Tidak Diketahui'
        ]);
    }
}
