<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    function index()
    {
        $stats = [
            'total_transaksi' => Transaksi::count(),
            'total_barang' => DetailTransaksi::count(),
            'total_pendapatan' => Transaksi::sum('total_harga'),
            'rata_transaksi' => Transaksi::avg('total_harga'),
        ];

        $query = Transaksi::query();

        if ($search = request('search')) {
            $query->where('id', 'like', "%{$search}%");
        }

        if ($date = request('date')) {
            $query->whereDate('tanggal', $date);
        }

        $transaksis = $query->with('details')->orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.transaksi.index', compact('stats', 'transaksis'));
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['details.barang']);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $transaksi->id,
                'tanggal' => \Carbon\Carbon::parse($transaksi->tanggal)->format('d/m/Y H:i:s'),
                'total_barang' => $transaksi->total_barang,
                'total_harga' => $transaksi->total_harga,
                'details' => $transaksi->details->map(function ($detail) {
                    return [
                        'id' => $detail->id,
                        'id_barang' => $detail->id_barang,
                        'nama_barang' => $detail->barang->nama_barang,
                        'jumlah' => $detail->jumlah,
                        'harga' => $detail->harga,
                        'formatted_harga' => 'Rp ' . number_format($detail->harga, 0, ',', '.'),
                    ];
                }),
            ]
        ]);
    }

    function delete(Transaksi $transaksi)
    {
        $transaksi->delete();

        return redirect()->route('dashboard.transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
