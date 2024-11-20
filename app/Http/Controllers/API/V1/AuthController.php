<?php
// app/Http/Controllers/API/V1/AuthController.php
namespace App\Http\Controllers\API\V1;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Pengguna;
use App\Models\Toko;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ResponseFormatter;
use App\Http\Resources\PenggunaResource;
use Illuminate\Http\Request;



class AuthController extends Controller
{
    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            // Create user
            $user = Pengguna::create([
                'nama' => $request->nama,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'peran' => 'admin',
                'id_toko' => null
            ]);

            // Create toko
            $toko = Toko::create([
                'nama_toko' => $request->nama_toko,
                'alamat_toko' => $request->alamat_toko,
                'id_admin' => $user->id
            ]);

            // Update user with toko
            $user->update(['id_toko' => $toko->id]);

            $token = $user->createToken('auth_token')->plainTextToken;

            DB::commit();
            
            return ResponseFormatter::success([
                'user' => new PenggunaResource($user),
                'token' => $token
            ], 'Registration successful');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormatter::error(null, $e->getMessage(), 500);
        }
    }
    public function login(LoginRequest $request)
    {
        try {
            // Menentukan tipe login (email atau username)
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Mencari pengguna berdasarkan loginType
        $user = Pengguna::where($loginType, $request->login)->first();

        // Verifikasi apakah user ditemukan dan password cocok
        if (!$user || !Hash::check($request->password, $user->password)) {
            return ResponseFormatter::error(null, 'Invalid credentials', 401);
        }

        // Membuat token autentikasi
        $token = $user->createToken('auth_token')->plainTextToken;

        // Mengembalikan respons sukses
        return ResponseFormatter::success([
            'user' => new PenggunaResource($user),
            'token' => $token
        ], 'Login successful');

    } catch (\Exception $e) {
        return ResponseFormatter::error(null, $e->getMessage(), 500);}
    }
    // public function logout(Request $request)
    // {
    //     $request->user()->currentAccessToken()->delete();
    //     return response()->json(
    //         [
    //             'status' => 'success',
    //             'message' => 'Berhasil Logout'
    //         ]
    //     );

    // } 
    
}