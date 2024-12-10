<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenggunaRequest extends FormRequest
{
    public function authorize()
    {
        // Pastikan hanya admin yang bisa membuat pengguna
        return $this->user()->can('admin');
    }

    public function rules()
    {
        return [
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:pengguna,email',
            'username' => 'required|string|max:50|unique:pengguna,username',
            'password' => 'required|string|min:6',
            'peran' => 'required|in:admin,kasir',
            'id_toko' => 'nullable|exists:toko,id',
        ];
    }
}
