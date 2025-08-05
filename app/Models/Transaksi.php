<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'tanggal',
        'total_harga',
        'total_harga',
    ];

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
}
