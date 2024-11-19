<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProdukController extends Controller
{
    // GET: Fetch all products
    public function index()
    {
        // $produk = 
        return Produk::all();
        // return response()->json($produk);
    }

    // POST: Add a new product
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'barcode' => 'required|string|max:50|unique:produk',
            'nama_produk' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'integer|min:0',
            'gambar' => 'nullable|string|max:255',
            'id_kategori' => 'nullable|exists:kategori,id',
        ]);

        $produk = Produk::create($validatedData);

        return response()->json($produk, 201);
    }

    // GET: Fetch a single product by ID
    public function show($id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($produk);
    }

    // PUT/PATCH: Update a product
    public function update(Request $request, $id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $validatedData = $request->validate([
            'barcode' => 'string|max:50|unique:produk,barcode,' . $id,
            'nama_produk' => 'string|max:100',
            'harga' => 'numeric|min:0',
            'stok' => 'integer|min:0',
            'gambar' => 'nullable|string|max:255',
            'id_kategori' => 'nullable|exists:kategori,id',
        ]);

        $produk->update($validatedData);

        return response()->json($produk);
    }

    // DELETE: Soft delete a product
    public function destroy($id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $produk->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}

