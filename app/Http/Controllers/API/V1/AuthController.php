<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Validation\Rule;


class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'no_hp' => 'required|string|max:255',
            'jenis_pengguna' => Rule::in (['pembeli', 'admin', 'kasir']),
            'referal_code' => 'string|max:5'
        ]);
    if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $pengguna = Pengguna::create($input);
        $success['token'] =  $pengguna->createToken('MyApp')->plainTextToken;
        $success['nama'] =  $pengguna->nama;
        return $this->sendResponse($success, 'User register successfully.');
    }
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $pengguna = Auth::user();
            $success['token'] =  $pengguna->createToken('MyApp')->plainTextToken;
            $success['nama'] =  $pengguna->nama;
            $success['result'] = "berhasil";

            return $this->sendResponse($success, 'User login successfully.');
        }else{
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(
            [
                'status' => 'success',
                'message' => 'Berhasil Logout'
            ]
        );

    } 
}