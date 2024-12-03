<?php

namespace App\Http\Controllers;

use App\Services\AuthServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthServices $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required',
            'password' => 'required'
        ]);

        $response = $this->authService->login($credentials);

        if ($response['success']) {
            return response()->json($response['data'], $response['status']);
        }

        return response()->json([
            'meta' => [
                'message' => $response['message']
            ]
        ], $response['status']);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'required',
            'nama_toko' => 'required',
            'alamat_toko' => 'required'
        ]);

        $response = $this->authService->register($data);

        if ($response['success']) {
            return response()->json($response['data'], $response['status']);
        }

        return response()->json([
            'meta' => [
                'message' => $response['message']
            ]
        ], $response['status']);
    }
}
