<?php

// app/Services/AuthServices.php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class AuthServices
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'http://127.0.0.1:8000/api/v1';
    }

    public function login($credentials)
    {
        try {
            $response = Http::post($this->baseUrl . '/login', [
                'login' => $credentials['login'],
                'password' => $credentials['password']
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                    'status' => $response->status()
                ];
            }

            return [
                'success' => false,
                'message' => $response->json()['meta']['message'] ?? 'Login failed',
                'status' => $response->status()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'status' => 500
            ];
        }
    }

    public function register($data)
    {
        try {
            $response = Http::post($this->baseUrl . '/register', [
                'nama' => $data['nama'],
                'email' => $data['email'],
                'username' => $data['username'],
                'password' => $data['password'],
                'nama_toko' => $data['nama_toko'],
                'alamat_toko' => $data['alamat_toko']
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json(),
                    'status' => $response->status()
                ];
            }

            return [
                'success' => false,
                'message' => $response->json()['meta']['message'] ?? 'Registration failed',
                'status' => $response->status()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'status' => 500
            ];
        }
    }
}
