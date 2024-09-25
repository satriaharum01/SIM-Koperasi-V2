<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    use HasFactory;
    protected $table = 'simpanan';
    protected $primaryKey = 'id_simpanan';
    protected $fillable = ['jumlah','keterangan','id_user','created_at'];

    public function cari_user()
    {
        return $this->belongsTo('App\Models\User', 'id_user', 'id')->withDefault([
            'name' => 'Tanpa Nama',
            'email' => 'Tidak Ada',
            'level' => 'Tidak Diketahui'
        ]);
    }
}
