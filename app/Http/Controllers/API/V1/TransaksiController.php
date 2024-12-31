<?php

// app/Http/Controllers/TransaksiController.php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['detailTransaksi.produk', 'pelanggan', 'kasir'])->get();
        return response()->json($transaksi);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->validate([
                'nomor_nota' => 'required|string|max:20|unique:transaksi,nomor_nota',
                'id_kasir' => 'required|exists:pengguna,id',
                'id_pelanggan' => 'nullable|exists:pelanggan,id',
                'id_toko' => 'required|exists:toko,id',
                'detail' => 'required|array',
                'detail.*.id_produk' => 'required|exists:produk,id',
                'detail.*.jumlah' => 'required|integer|min:1',
                'detail.*.harga_satuan' => 'required|numeric|min:0',
                'jumlah_bayar' => 'required|numeric|min:0',
            ]);

            $total = 0;

            foreach ($data['detail'] as $item) {
                $total += $item['jumlah'] * $item['harga_satuan'];
            }

            $kembalian = $data['jumlah_bayar'] - $total;

            if ($kembalian < 0) {
                return response()->json(['message' => 'Jumlah bayar tidak mencukupi'], 400);
            }

            $transaksi = Transaksi::create([
                'nomor_nota' => $data['nomor_nota'],
                'id_kasir' => $data['id_kasir'],
                'id_pelanggan' => $data['id_pelanggan'],
                'id_toko' => $data['id_toko'],
                'total' => $total,
                'jumlah_bayar' => $data['jumlah_bayar'],
                'kembalian' => $kembalian,
            ]);

            foreach ($data['detail'] as $item) {
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id,
                    'id_produk' => $item['id_produk'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                ]);

                $produk = Produk::find($item['id_produk']);
                $produk->decrement('stok', $item['jumlah']);
            }

            DB::commit();

            return response()->json($transaksi->load('detailTransaksi'), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}

