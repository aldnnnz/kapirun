<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Login extends Component
{
    public $login = '';
    public $password = '';

    public function login()
    {
        $this->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $response = Http::post('http://127.0.0.1:8000/api/v1/login', [
            'login' => $this->login,
            'password' => $this->password,
        ]);

        if ($response->successful()) {
            $responseBody = $response->json();

            // Cek status meta success
            if ($responseBody['meta']['success']) {
                // Simpan token dan user info di session
                Session::put('token', $responseBody['data']['token']);
                Session::put('user', $responseBody['data']['user']);

                // Redirect ke halaman utama
                return redirect()->route('home');
            }

            // Jika gagal, tampilkan pesan error
            $this->addError('login', $responseBody['meta']['message']);
        } else {
            $this->addError('login', 'Terjadi kesalahan pada server. Coba lagi nanti.');
        }
    }

    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.auth');
    }
}