<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SolutionController extends Controller
{
    private $BASE_URL = "https://kindlyblade-us.backendless.app";

    public function createSolution(Request $request, $slug)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
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
        ];


        // Kirim data ke API
        $createSolutionResponse = Http::post($this->BASE_URL . '/api/data/solutions', $payload);

        if (!$createSolutionResponse->successful()) {
            Log::error('Error creating solution:', ['response' => $createSolutionResponse->body()]);
            return back()->withErrors(['error' => 'Gagal membuat laporan di Backendless']);
        }

        // Ambil ID laporan yang baru dibuat
        $solutionObjectId = $createSolutionResponse->json()['objectId'];
        Log::info('Response from Backendless:', [
            'response_data_reportId' => $solutionObjectId,
        ]);

        // Cek apakah laporan benar-benar ada
        $solutionExists = Http::get($this->BASE_URL . "/api/data/solutions/{$solutionObjectId}");
        if (!$solutionExists->successful()) {
            Log::error('Solution not found in Backendless:', ['reportId' => $solutionObjectId]);
            return back()->withErrors(['error' => 'Solusi tidak ditemukan di Backendless']);
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
        ])->put($this->BASE_URL . "/api/data/accounts/{$accountId}/solutionList", [
            'objectIds' => $solutionObjectId
        ]);

        $relationSolutionAccountResponse = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->put($this->BASE_URL . "/api/data/solutions/{$solutionObjectId}/ownerData", [
            'objectIds' => $accountId
        ]);

        ////////////
        $reportObjectId = $slug;
        Log::info('Response from Backendless:', [
            'slug_reportId' => $solutionObjectId,
        ]);
        $relationReportSolutionResponse = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->put($this->BASE_URL . "/api/data/reports/{$reportObjectId}/solutionReportList", [
            'objectIds' => $solutionObjectId
        ]);

        $relationSolutionReportResponse = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->put($this->BASE_URL . "/api/data/solutions/{$solutionObjectId}/reportData", [
            'objectIds' => $reportObjectId
        ]);


        // Tangani respons
        if (
            $createSolutionResponse->successful() &&
            $relationAccountResponse->successful() &&
            $relationSolutionAccountResponse->successful() &&
            $relationReportSolutionResponse->successful() &&
            $relationSolutionReportResponse->successful()
        ) {
            return back()->with('success', 'Solusi berhasil dibuat');
        } else {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat membuat solusi']);
        }
    }
}
