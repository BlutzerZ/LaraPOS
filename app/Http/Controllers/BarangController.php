<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    function index(Request $request)
    {
        $search = $request->query('search');

        $query = Barang::query();
        if ($search) {
            $query->where('nama_barang', 'like', '%' . $search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $search . '%');
        }
        $barangs = $query->paginate(10);

        return view('dashboard.barang.index', compact('barangs'));
    }

    function create()
    {
        return view('dashboard.barang.create');
    }

    function store(Request $request)
    {
        $data = $request->validate([
            'kode_barang' => 'required|string|max:255|unique:barangs,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'harga' => 'required|integer',
        ]);

        Barang::create($data);

        return redirect()->route('dashboard.barang.index')->with('success', 'Barang created successfully.');
    }

    function edit(Barang $barang)
    {
        return view('dashboard.barang.edit', compact('barang'));
    }

    function update(Request $request, Barang $barang)
    {
        $data = $request->validate([
            'kode_barang' => 'required|string|max:255|unique:barangs,kode_barang',
            'nama_barang' => 'required|string|max:255',
            'harga' => 'required|integer',
        ]);

        $barang->update($data);

        return redirect()->route('dashboard.barang.index')->with('success', 'Barang updated successfully.');
    }

    function delete(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('dashboard.barang.index')->with('success', 'Barang deleted successfully.');
    }
}

