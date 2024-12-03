<?php
// app/Livewire/Auth/Login.php
namespace App\Livewire\Auth;

use Livewire\Component;
use App\Services\AuthServices;
use Illuminate\Support\Facades\Session;
use Livewire\Redirector;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengguna;

class Login extends Component
{
    public $login, $password;

    protected $rules = [
        'login' => 'required', 
        'password' => 'required|min:6',
    ];

    public function login()
    {
        logger('Validasi dimulai');
        $this->validate();
        logger('Validasi selesai');

        // Coba login dengan email atau username
        $user = filter_var($this->login, FILTER_VALIDATE_EMAIL)
            ? Pengguna::where('email', $this->login)->first()
            : Pengguna::where('username', $this->login)->first();
            logger('User ditemukan: ' . ($user ? $user->email : 'Tidak ada'));
            if ($user && Auth::attempt(['email' => $user->email, 'password' => $this->password])) {
                logger('Login berhasil');
                session()->regenerate();
                return redirect()->route('pages.home');
            } else {
                logger('Login gagal: ' . ($user ? 'Password salah' : 'User tidak ditemukan'));
            }
            

        session()->flash('error', 'Email/Username atau password salah.');
        return null;
    }
    public function testDebug()
{
    logger('Metode testDebug Livewire berhasil dipanggil');
}

    public function render()
    {
        logger('Komponen Livewire Login dirender');
        return view('livewire.auth.login')
            ->extends('layouts.auth')
            ->section('content');
    }
}