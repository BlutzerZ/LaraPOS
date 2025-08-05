<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    function index()
    {
        $barangs = Barang::paginate(10);
        return view('dashboard.kasir.index', compact('barangs'));
    }

    function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:barangs,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
        ]);

        $transaksi = Transaksi::insertGetId([
            'Tanggal' => now(),
            'Total_Barang' => collect($request->items)->sum('quantity'),
            'Total_Harga' => $request->total,
        ]);

        foreach ($request->items as $item) {
            DetailTransaksi::insert([
            'ID_Transaksi' => $transaksi,
            'ID_Barang' => $item['product_id'],
            'Harga' => $item['price'],
            'jumlah' => $item['quantity'],
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Transaksi berhasil disimpan.']);
    }
}
