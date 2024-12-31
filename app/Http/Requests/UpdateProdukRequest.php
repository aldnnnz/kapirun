<?php
// app/Http/Requests/UpdateProdukRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProdukRequest extends StoreProdukRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'kode' => 'required|string|max:20',
            'nama_produk' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'id_kategori' => 'nullable|exists:kategori,id',
            'gambar' => 'nullable|image|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'kode.required' => 'Kode produk harus diisi',
            'nama_produk.required' => 'Nama produk harus diisi',
            'harga.required' => 'Harga produk harus diisi',
            'harga.min' => 'Harga tidak boleh negatif',
            'stok.required' => 'Stok produk harus diisi',
            'stok.min' => 'Stok tidak boleh negatif',
            'id_kategori.exists' => 'Kategori tidak ditemukan',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.max' => 'Ukuran gambar maksimal 2MB'
        ];
    }
}