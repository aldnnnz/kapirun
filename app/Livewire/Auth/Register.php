<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Services\AuthServices;
use Illuminate\Support\Facades\Session;
use Livewire\Redirector;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Toko;
use Illuminate\Support\Facades\DB;

class Register extends Component
{
    public $nama;
    public $username;
    public $email;
    public $nama_toko;
    public $telepon_toko;
    public $alamat_toko;
    public $password;
    public $password_confirmation;

    protected $rules = [
        'nama' => 'required|string|max:100',
        'username' => 'required|string|max:50|unique:pengguna',
        'email' => 'required|email|max:100|unique:pengguna',
        'nama_toko' => 'required|string|max:100',
        'telepon_toko' => 'nullable|string|max:15',
        'alamat_toko' => 'required|string',
        'password' => 'required|string|min:8|confirmed',
    ];

    public function register()
{
    $this->validate();

    try {
        DB::beginTransaction();

        $pengguna = Pengguna::create([
            'nama' => $this->nama,
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'peran' => 'admin'
        ]);

        $toko = Toko::create([
            'nama_toko' => $this->nama_toko,
            'alamat_toko' => $this->alamat_toko,
            'telepon_toko' => $this->telepon_toko,
            'id_admin' => $pengguna->id
        ]);

        $pengguna->update(['id_toko' => $toko->id]);

        DB::commit();

        Auth::login($pengguna);
        return redirect()->intended('/product');
    } catch (\Exception $e) {
        DB::rollBack();
        session()->flash('error', 'Registration failed. Please try again.');
    }
}

    public function render()
    {
        return view('livewire.auth.register')
        ->extends('layouts.auth')
        ->section('content');
    }
}
