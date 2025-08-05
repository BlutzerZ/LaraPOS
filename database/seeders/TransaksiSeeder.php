<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangs = DB::table('barangs')->get();

        for ($i = 1; $i <= 3; $i++) {

            $selectedBarangs = $barangs->random(rand(2, 3));

            $totalBarang = 0;
            $totalHarga = 0;

            $idTransaksi = DB::table('transaksis')->insertGetId([
                'tanggal' => Carbon::now()->subDays(rand(0, 10)),
                'total_barang' => 0,
                'total_harga' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($selectedBarangs as $barang) {
                $jumlah = rand(1, 5);
                $subtotal = $barang->harga * $jumlah;

                DB::table('detail_transaksis')->insert([
                    'id_transaksi' => $idTransaksi,
                    'id_barang' => $barang->id,
                    'harga' => $barang->harga,
                    'jumlah' => $jumlah,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $totalBarang += $jumlah;
                $totalHarga += $subtotal;
            }

            DB::table('transaksis')
                ->where('id', $idTransaksi)
                ->update([
                    'total_barang' => $totalBarang,
                    'total_harga' => $totalHarga,
                    'updated_at' => now(),
                ]);
        }
    }
}
