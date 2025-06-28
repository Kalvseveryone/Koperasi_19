<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kolektor;
use App\Models\Anggota;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class MobileAuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email'    => 'required|email',
                'password' => 'required'
            ]);

            // Admin
            $admin = User::where('email', $request->email)->first();
            if ($admin && Hash::check($request->password, $admin->password)) {
                $token = $admin->createToken('admin_token', ['admin'])->plainTextToken;
                
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil',
                    'role'    => 'admin',
                    'user'    => $admin,
                    'token'   => $token
                ]);
            }

            // Kolektor
            $kolektor = Kolektor::where('email', $request->email)->first();
            if ($kolektor && Hash::check($request->password, $kolektor->password)) {
                $token = $kolektor->createToken('kolektor_token', ['kolektor'])->plainTextToken;
                
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil',
                    'role'    => 'kolektor',
                    'user'    => $kolektor,
                    'token'   => $token
                ]);
            }

            // Anggota
            $anggota = Anggota::where('email', $request->email)->first();
            if ($anggota && Hash::check($request->password, $anggota->password)) {
                $token = $anggota->createToken('anggota_token', ['anggota'])->plainTextToken;
                
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil',
                    'role'    => 'anggota',
                    'user'    => $anggota,
                    'token'   => $token
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah'
            ], 401);
            
        } catch (\Exception $e) {
            Log::error('Mobile login error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil'
            ]);
        } catch (\Exception $e) {
            Log::error('Mobile logout error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat logout'
            ], 500);
        }
    }

    public function me(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token tidak valid atau telah berakhir'
                ], 401);
            }
            
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            Log::error('Mobile me error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }
}