<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReportController extends Controller
{
    private $BASE_URL = "https://kindlyblade-us.backendless.app";

    public function getReports()
    {
        $response = Http::get($this->BASE_URL . '/api/data/reports');

        // Periksa apakah permintaan berhasil
        if ($response->successful()) {
            $reports = $response->json();
            return view('reports.index', compact('reports')); // Tampilkan di view
        } else {
            return back()->withErrors(['error' => 'Gagal mengambil data laporan']);
        }
    }

    public function show($slug)
    {
        // Fetch data dari API menggunakan slug
        $apiUrl = $this->BASE_URL . "/api/data/reports/{$slug}";

        try {
            $response = Http::get($apiUrl);

            if ($response->successful()) {
                $reportData = $response->json();

                // Return data ke view atau JSON
                return view('reports.show', ['report' => $reportData]);
            }

            return response()->json(['error' => 'Data not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

    public function createReport(Request $request)
    {
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
        $response = Http::post($this->BASE_URL . '/api/data/reports', $validated);

        // Tangani respons
        if ($response->successful()) {
            return back()->with('success', 'Laporan berhasil dibuat');
        } else {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat membuat laporan']);
        }
    }
}
