<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:pengguna,email'],
            'username' => ['required', 'string', 'max:50', 'unique:pengguna,username'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
            'nama_toko' => ['required', 'string', 'max:100'],
            'alamat_toko' => ['required', 'string']
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama harus diisi',
            'nama.max' => 'Nama maksimal 100 karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email maksimal 100 karakter',
            'email.unique' => 'Email sudah terdaftar',
            'username.required' => 'Username harus diisi',
            'username.max' => 'Username maksimal 50 karakter',
            'username.unique' => 'Username sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.max' => 'Password maksimal 255 karakter',
            'nama_toko.required' => 'Nama toko harus diisi',
            'nama_toko.max' => 'Nama toko maksimal 100 karakter',
            'alamat_toko.required' => 'Alamat toko harus diisi'
        ];
    }
}
