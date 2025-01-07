<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SignupController extends Controller
{
    public function store(Request $request)
    {
        // #input validation
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'confirm-password' => 'required|same:password',
        ]);

        // #data payload
        $payload = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];

        // #send request to API
        $response = Http::post('https://kindlyblade-us.backendless.app/api/data/accounts', $payload);

        // #handling response
        if ($response->successful()) {
            return back()->with('success', 'Akun berhasil dibuat');
        } else {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat membuat akun']);
        }
    }
}
