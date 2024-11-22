<?php

namespace App\Http\Controllers\API\V1;


use App\Models\Produk;
use App\Models\RiwayatStok;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;
use App\Http\Resources\ProdukResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProdukController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $produk = Produk::with('kategori')
            ->where('id_toko', $user->id_toko)
            ->latest()
            ->get();
            
        return ResponseFormatter::success(
            ProdukResource::collection($produk),
            'Data produk berhasil diambil'
        );
    }

    public function store(StoreProdukRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            
            // Handle gambar
            $gambarPath = null;
            if ($request->hasFile('gambar')) {
                $gambarPath = $request->file('gambar')->store('produk', 'public');
            }

            // Simpan produk
            $produk = Produk::create([
                'kode' => $request->kode,
                'nama_produk' => $request->nama_produk,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'gambar' => $gambarPath,
                'id_kategori' => $request->id_kategori,
                'id_toko' => $user->id_toko
            ]);

            // Catat riwayat stok
            if ($request->stok > 0) {
                RiwayatStok::create([
                    'id_produk' => $produk->id,
                    'perubahan_stok' => $request->stok,
                    'tipe' => 'masuk',
                    'harga_satuan' => $request->harga,
                    'id_pengguna' => $user->id,
                    'id_toko' => $user->id_toko
                ]);
            }

            DB::commit();
            return ResponseFormatter::success(
                new ProdukResource($produk),
                'Produk berhasil ditambahkan'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormatter::error(
                null,
                'Terjadi kesalahan: ' . $e->getMessage(),
                500
            );
        }
    }

    public function show($id)
    {
        $user = Auth::user();
        $produk = Produk::with(['kategori', 'riwayatStok'])
            ->where('id_toko', $user->id_toko)
            ->findOrFail($id);
            
        return ResponseFormatter::success(
            new ProdukResource($produk),
            'Detail produk berhasil diambil'
        );
    }

    public function update(UpdateProdukRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user();
            $produk = Produk::where('id_toko', $user->id_toko)->findOrFail($id);
            
            // Hitung perubahan stok
            $perubahanStok = $request->stok - $produk->stok;

            // Handle gambar
            if ($request->hasFile('gambar')) {
                if ($produk->gambar) {
                    Storage::disk('public')->delete($produk->gambar);
                }
                $gambarPath = $request->file('gambar')->store('produk', 'public');
            } else {
                $gambarPath = $produk->gambar;
            }

            // Update produk
            $produk->update([
                'nama_produk' => $request->nama_produk,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'gambar' => $gambarPath,
                'id_kategori' => $request->id_kategori
            ]);

            // Catat riwayat stok jika ada perubahan
            if ($perubahanStok != 0) {
                RiwayatStok::create([
                    'id_produk' => $produk->id,
                    'perubahan_stok' => abs($perubahanStok),
                    'tipe' => $perubahanStok > 0 ? 'masuk' : 'keluar',
                    'harga_satuan' => $request->harga,
                    'id_pengguna' => $user->id,
                    'id_toko' => $user->id_toko
                ]);
            }

            DB::commit();
            return ResponseFormatter::success(
                new ProdukResource($produk),
                'Produk berhasil diperbarui'
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormatter::error(
                null,
                'Terjadi kesalahan: ' . $e->getMessage(),
                500
            );
        }
    }

    public function destroy($id)
    {
        try {
            $user = Auth::user();
            $produk = Produk::where('id_toko', $user->id_toko)->findOrFail($id);

            if ($produk->gambar) {
                Storage::disk('public')->delete($produk->gambar);
            }

            $produk->delete();

            return ResponseFormatter::success(
                null,
                'Produk berhasil dihapus'
            );
        } catch (\Exception $e) {
            return ResponseFormatter::error(
                null,
                'Terjadi kesalahan: ' . $e->getMessage(),
                500
            );
        }
    }
}