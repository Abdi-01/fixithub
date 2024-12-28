<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// #define route for access page
Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/signup', function () {
    return view('signup');
});

// #define route for API call
Route::post('/submit', function (Request $request) {
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
})->name('register.submit');
