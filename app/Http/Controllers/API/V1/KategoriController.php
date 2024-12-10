<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function index()
    {
        try {
            // Ambil toko dari pengguna yang sedang login
            $user = Auth::user();
            $idToko = $user->id_toko;

            // Validasi apakah pengguna memiliki toko
            if (!$idToko) {
                return ResponseFormatter::error('User tidak memiliki akses ke toko.', 403);
            }

            // Ambil kategori berdasarkan toko
            $kategori = Kategori::where('id_toko', $idToko)->get();

            return ResponseFormatter::success($kategori, 'Data kategori berhasil diambil.');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user->id_toko) {
                return ResponseFormatter::error('User tidak memiliki akses ke toko.', 403);
            }

            $validated = $request->validate([
                'nama_kategori' => 'required|string|max:50'
            ]);

            $validated['id_user'] = Auth::id();
            $validated['id_toko'] = $user->id_toko;
            $kategori = Kategori::create($validated);

            return ResponseFormatter::success($kategori, 'Kategori berhasil ditambahkan');
        } catch (\Exception $e) {
            return ResponseFormatter::error('Gagal menambahkan kategori', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            return ResponseFormatter::success($kategori, 'Data kategori berhasil diambil');
        } catch (\Exception $e) {
            return ResponseFormatter::error('Kategori tidak ditemukan', 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = Auth::user();
            
            if (!$user->id_toko) {
                return ResponseFormatter::error('User tidak memiliki akses ke toko.', 403);
            }

            $validated = $request->validate([
                'nama_kategori' => 'required|string|max:50'
            ]);

            $validated['id_user'] = Auth::id();
            $validated['id_toko'] = $user->id_toko;
            
            $kategori = Kategori::findOrFail($id);
            $kategori->update($validated);

            return ResponseFormatter::success($kategori, 'Kategori berhasil diperbarui');
        } catch (\Exception $e) {
            return ResponseFormatter::error('Gagal memperbarui kategori', 500);
        }    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $kategori = Kategori::findOrFail($id);
            $kategori->delete();

            return ResponseFormatter::success(null, 'Kategori berhasil dihapus');
        } catch (\Exception $e) {
            return ResponseFormatter::error('Gagal menghapus kategori', 500);
        }
    }
}
