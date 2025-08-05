<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('barangs')->insert([
            [
                'kode_barang' => 'BRG001',
                'nama_barang' => 'Pensil 2B',
                'harga' => 2000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'BRG002',
                'nama_barang' => 'Buku Tulis',
                'harga' => 5000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'BRG003',
                'nama_barang' => 'Penghapus',
                'harga' => 1500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_barang' => 'BRG004',
                'nama_barang' => 'Penggaris 30cm',
                'harga' => 3000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
