<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ],422);
        }

        // cek login
        if(!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])){
            return response()->json([
                'status' => false,
                'message' => 'Email atau password salah'
            ],401);
        }

        // ambil user
        $user = Auth::user();

        // buat token sanctum
        $token = $user->createToken('hotel-api')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login berhasil',
            'token' => $token,
            'role' => $user->role,
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        // hapus token yang sedang dipakai
        $request->user()->currentAccessToken()->delete();
    
        return response()->json([
            'status' => true,
            'message' => 'Logout berhasil'
        ]);
    }
}
