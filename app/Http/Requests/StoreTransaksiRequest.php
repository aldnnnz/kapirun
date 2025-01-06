<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_kasir' => 'required|exists:pengguna,id',
            'id_pelanggan' => 'nullable|exists:pelanggan,id',
            'id_toko' => 'required|exists:toko,id',
            'jumlah_bayar' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.id_produk' => 'required|exists:produk,id',
            'items.*.jumlah' => 'required|integer|min:1'
        ];
    }
}