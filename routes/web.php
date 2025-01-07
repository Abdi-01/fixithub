<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

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

Route::get('/problem-timeline', function () {
    return view('problem');
});

Route::get('/reports/{slug}', [ReportController::class, 'show']);


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

Route::post('/report/submit', function (Request $request) {
    // Validasi input
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'location' => 'required|string',
        'category' => 'required|string',
        // 'mediafile' => 'nullable|file|mimes:jpg,png,gif,svg|max:2048',
    ]);

    // Upload file jika ada
    // if ($request->hasFile('mediafile')) {
    //     $file = $request->file('mediafile');
    //     $filePath = $file->store('uploads', 'public'); // Simpan di storage/public/uploads
    //     $validated['mediafile'] = $filePath;
    // }

    // Kirim data ke API
    $response = Http::post('https://kindlyblade-us.backendless.app/api/data/reports', $validated);

    // Tangani respons
    if ($response->successful()) {
        return back()->with('success', 'Laporan berhasil dibuat');
    } else {
        return back()->withErrors(['error' => 'Terjadi kesalahan saat membuat laporan']);
    }
})->name('report.submit');

Route::get('/reports', function () {
    // Kirim permintaan GET ke API
    $response = Http::get('https://kindlyblade-us.backendless.app/api/data/reports');

    // Periksa apakah permintaan berhasil
    if ($response->successful()) {
        $reports = $response->json();
        return view('reports.index', compact('reports')); // Tampilkan di view
    } else {
        return back()->withErrors(['error' => 'Gagal mengambil data laporan']);
    }
})->name('reports.index');
