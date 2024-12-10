<?php
// app/Livewire/Auth/Login.php
namespace App\Livewire\Auth;

use Livewire\Component;
use App\Services\AuthServices;
use Illuminate\Support\Facades\Session;
use Livewire\Redirector;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna;
use App\Models\Toko;
use Illuminate\Support\Facades\Hash;

class Login extends Component
{
    public $username, $password, $remember = false;

    protected $rules = [
        'username' => 'required', 
        'password' => 'required|min:6',
    ];

    public function login()
{
    logger('Metode login() dipanggil'); // Log pertama
    
    $this->validate();
    logger('Validasi selesai'); // Log kedua

    $user = Pengguna::where('username', $this->username)->first();
    
    logger('User ditemukan', ['user' => $user]); // Log ketiga

    if ($user && Hash::check($this->password, $user->password)) {
        logger('Login berhasil'); // Log keempat

        Auth::login($user, $this->remember);
        session()->regenerate();

        // Atur session toko
        if ($user->peran === 'admin') {
            $toko = Toko::where('id_admin', $user->id)->first();
            session(['id_toko' => $toko ? $toko->id : null]);
        } elseif ($user->peran === 'kasir') {
            session(['id_toko' => $user->id_toko]);
        }

        return redirect()->route('pages.product');
    }

    session()->flash('error', 'Username atau password salah.');
    logger('Login gagal'); // Log kelima
    return null;
}

    public function render()
    {
        logger('Komponen Livewire Login dirender');
        return view('livewire.auth.login')
            ->extends('layouts.auth')
            ->section('content');
    }
}