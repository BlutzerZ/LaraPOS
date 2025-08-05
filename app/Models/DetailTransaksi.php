<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $fillable = [
        'id_transaksi',
        'id_barang',
        'harga',
        'jumlah',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }
}
