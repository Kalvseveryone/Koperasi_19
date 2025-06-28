<?php

namespace App\Http\Controllers;

use App\Models\Kolektor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Menangani login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Clear any existing sessions first
        Auth::guard('web')->logout();
        Auth::guard('kolektor')->logout();
        Auth::guard('anggota')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Check if user exists in admin table
        $admin = User::where('email', $credentials['email'])->first();
        
        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            Auth::guard('web')->login($admin);
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }

        // If not admin, check kolektor
        $kolektor = Kolektor::where('email', $credentials['email'])->first();
        
        if ($kolektor && Hash::check($credentials['password'], $kolektor->password)) {
            Auth::guard('kolektor')->login($kolektor);
            $request->session()->regenerate();
            return redirect()->intended('/kolektor/dashboard')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }

        // If not kolektor, check anggota
        $anggota = \App\Models\Anggota::where('email', $credentials['email'])->first();
        
        if ($anggota && Hash::check($credentials['password'], $anggota->password)) {
            Auth::guard('anggota')->login($anggota);
            $request->session()->regenerate();
            return redirect()->intended('/anggota/dashboard')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout(Request $request)
    {
        // Clear all possible sessions and authentication
        Auth::guard('web')->logout();
        Auth::guard('kolektor')->logout();

        // Forget all sessions
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Clear any remember me cookies
        Cookie::forget('laravel_session');
        
        // Redirect with cache control headers
        return redirect('/login')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }
}
