<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    private $BASE_URL = "https://kindlyblade-us.backendless.app";

    public function getReports()
    {
        $response = Http::get($this->BASE_URL . '/api/data/reports?loadRelations=ownerData&&sortBy=%60created%60%20desc');

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
        $apiUrl = $this->BASE_URL . "/api/data/reports/{$slug}?loadRelations=ownerData%2CsolutionReportList.ownerData";

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

        $accountId = session('user') ? session('user')['objectId'] : null;

        // Periksa apakah data user ada
        if (!$accountId) {
            return back()->withErrors(['error' => 'Data pengguna tidak ditemukan dalam sesi']);
        }
        Log::info('Response from Backendless:', [
            'response_data_account' => $accountId,
        ]);

        // Gabungkan data validasi dengan email
        $payload = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'category' => $validated['category'],
        ];


        // Kirim data ke API
        $createReportResponse = Http::post($this->BASE_URL . '/api/data/reports', $payload);

        if (!$createReportResponse->successful()) {
            Log::error('Error creating report:', ['response' => $createReportResponse->body()]);
            return back()->withErrors(['error' => 'Gagal membuat laporan di Backendless']);
        }

        // Ambil ID laporan yang baru dibuat
        $reportObjectId = $createReportResponse->json()['objectId'];
        Log::info('Response from Backendless:', [
            'response_data_reportId' => $reportObjectId,
        ]);

        // Cek apakah laporan benar-benar ada
        $reportExists = Http::get($this->BASE_URL . "/api/data/reports/{$reportObjectId}");
        if (!$reportExists->successful()) {
            Log::error('Report not found in Backendless:', ['reportId' => $reportObjectId]);
            return back()->withErrors(['error' => 'Laporan tidak ditemukan di Backendless']);
        }

        // Cek apakah akun benar-benar ada
        $accountExists = Http::get($this->BASE_URL . "/api/data/accounts/{$accountId}");
        if (!$accountExists->successful()) {
            Log::error('Account not found in Backendless:', ['accountId' => $accountId]);
            return back()->withErrors(['error' => 'Akun tidak ditemukan di Backendless']);
        }

        // Buat relasi antara laporan dan akun di Backendless
        $relationAccountResponse = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->put($this->BASE_URL . "/api/data/accounts/{$accountId}/reportList", [
            'objectIds' => $reportObjectId
        ]);

        $relationReportResponse = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->put($this->BASE_URL . "/api/data/reports/{$reportObjectId}/ownerData", [
            'objectIds' => $accountId
        ]);


        // Tangani respons
        if ($createReportResponse->successful() && $relationAccountResponse->successful() && $relationReportResponse->successful()) {
            return back()->with('success', 'Laporan berhasil dibuat');
        } else {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat membuat laporan']);
        }
    }
}
