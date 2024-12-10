<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Http\Requests\StorePenggunaRequest;
use App\Http\Requests\UpdatePenggunaRequest;
use App\Helpers\ResponseFormatter;
use Exception;

class PenggunaController extends Controller
{
    // Menyimpan pengguna baru
    public function store(StorePenggunaRequest $request)
    {
        $this->authorize('admin');
        try {
            // Membuat pengguna baru
            $pengguna = Pengguna::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'username' => $request->username,
                'password' => bcrypt($request->password),  // Enkripsi password
                'peran' => $request->peran,
                'id_toko' => $request->id_toko,
            ]);

            // Mengembalikan respons sukses
            return ResponseFormatter::success($pengguna, 'Pengguna berhasil dibuat', 201);

        } catch (Exception $e) {
            // Menangani error dan mengembalikan respons error
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    // Memperbarui data pengguna
    public function update(UpdatePenggunaRequest $request, $id)
    {
        $this->authorize('admin');
        try {
            // Menemukan pengguna berdasarkan ID
            $pengguna = Pengguna::findOrFail($id);

            // Update data pengguna
            $pengguna->update([
                'nama' => $request->nama ?? $pengguna->nama,
                'email' => $request->email ?? $pengguna->email,
                'username' => $request->username ?? $pengguna->username,
                'password' => $request->password ? bcrypt($request->password) : $pengguna->password,
                'peran' => $request->peran ?? $pengguna->peran,
                'id_toko' => $request->id_toko ?? $pengguna->id_toko,
            ]);

            // Mengembalikan respons sukses
            return ResponseFormatter::success($pengguna, 'Pengguna berhasil diperbarui');

        } catch (Exception $e) {
            // Menangani error dan mengembalikan respons error
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    // Menghapus pengguna
    public function destroy($id)
    {
        $this->authorize('admin');
        try {
            // Menemukan pengguna berdasarkan ID
            $pengguna = Pengguna::findOrFail($id);
            
            // Menghapus pengguna
            $pengguna->delete();

            // Mengembalikan respons sukses
            return ResponseFormatter::success(null, 'Pengguna berhasil dihapus');
            
        } catch (Exception $e) {
            // Menangani error dan mengembalikan respons error
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    // Menampilkan detail pengguna berdasarkan ID
    public function show($id)
    {
        $this->authorize('admin');
        try {
            // Menemukan pengguna berdasarkan ID
            $pengguna = Pengguna::findOrFail($id);

            // Mengembalikan respons sukses
            return ResponseFormatter::success($pengguna, 'Detail pengguna berhasil diambil');

        } catch (Exception $e) {
            // Menangani error dan mengembalikan respons error
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }
}
