<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function signin(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // URL Backendless dan query filter
        $url = env('BASE_URL_API') . "/api/data/accounts";
        $whereClause = "email = '{$credentials['email']}' AND password = '{$credentials['password']}'";
        $encodedWhereClause = urlencode($whereClause);

        // Request ke Backendless
        $response = Http::get("{$url}?where={$encodedWhereClause}");

        // Log data sebelum disimpan ke session
        Log::info('Response from Backendless:', [
            'response_data' => $response->json(),
        ]);

        // Cek jika ada data pengguna
        if ($response->successful() && count($response->json()) > 0) {
            $user = $response->json()[0]; // Ambil data pengguna pertama

            // Simpan ke session
            session(['user' => $user]);

            // Log data setelah disimpan ke session
            Log::info('User data stored in session:', [
                'session_user' => session('user'),
            ]);

            return redirect('/')->with('success', 'Anda berhasil masuk!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/signin')->with('success', 'Anda berhasil keluar.');
    }
}
