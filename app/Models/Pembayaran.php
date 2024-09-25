<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $table = 'pinjaman_bayar';
    protected $primaryKey = 'id_bayar';
    protected $fillable = ['jumlah','keterangan','id_pinjam','created_at'];

    public function cari_pinjaman()
    {
        return $this->belongsTo('App\Models\Pinjaman', 'id_pinjam', 'id_pinjam');
    }


}
