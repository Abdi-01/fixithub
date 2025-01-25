<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class SolutionController extends Controller
{
    public function createSolution(Request $request, $slug)
    {
        // Validasi input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'mediafile' => 'nullable|file|mimes:pdf,jpg,png,gif,svg|max:2048',
        ]);

        // Upload file ke Cloudinary jika ada
        $mediaUrl = null;
        if ($request->hasFile('mediafile')) {
            // Dapatkan tipe MIME file
            $fileMimeType = $request->file('mediafile')->getMimeType();

            // Konfigurasi upload berdasarkan tipe file
            if (str_contains($fileMimeType, 'image')) {
                // Jika file adalah gambar
                $uploadedFileUrl = Cloudinary::upload($request->file('mediafile')->getRealPath(), [
                    'folder' => 'fixithub/reports', // Folder khusus gambar
                    'transformation' => [
                        'width' => 800,
                        'height' => 400,
                        'crop' => 'limit',
                        'quality' => 'auto',
                    ],
                ])->getSecurePath();
            } elseif ($fileMimeType === 'application/pdf') {
                // Jika file adalah PDF
                $uploadedFileUrl = Cloudinary::upload($request->file('mediafile')->getRealPath(), [
                    'folder' => 'fixithub/reports', // Folder khusus PDF
                    'resource_type' => 'raw', // Resource type untuk PDF
                ])->getSecurePath();
            } else {
                // Tipe file tidak sesuai, return error atau handle sesuai kebutuhan
                return back()->withErrors(['mediafile' => 'Tipe file tidak didukung.']);
            }

            $mediaUrl = $uploadedFileUrl; // URL file di Cloudinary
        }

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
            'category' => $validated['category'],
            'mediafile' => $mediaUrl
        ];


        // Kirim data ke API
        $createSolutionResponse = Http::post(env('BASE_URL_API') . '/api/data/solutions', $payload);

        if (!$createSolutionResponse->successful()) {
            Log::error('Error creating solution:', ['response' => $createSolutionResponse->body()]);
            return back()->withErrors(['error' => 'Gagal membuat solusi di Backendless']);
        }

        // Ambil ID solusi yang baru dibuat
        $solutionObjectId = $createSolutionResponse->json()['objectId'];
        Log::info('Response from Backendless:', [
            'response_data_reportId' => $solutionObjectId,
        ]);

        // Cek apakah solusi benar-benar ada
        $solutionExists = Http::get(env('BASE_URL_API') . "/api/data/solutions/{$solutionObjectId}");
        if (!$solutionExists->successful()) {
            Log::error('Solution not found in Backendless:', ['reportId' => $solutionObjectId]);
            return back()->withErrors(['error' => 'Solusi tidak ditemukan di Backendless']);
        }

        // Cek apakah akun benar-benar ada
        $accountExists = Http::get(env('BASE_URL_API') . "/api/data/accounts/{$accountId}");
        if (!$accountExists->successful()) {
            Log::error('Account not found in Backendless:', ['accountId' => $accountId]);
            return back()->withErrors(['error' => 'Akun tidak ditemukan di Backendless']);
        }

        // Buat relasi antara solusi dan akun di Backendless
        $relationAccountResponse = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->put(env('BASE_URL_API') . "/api/data/accounts/{$accountId}/solutionList", [
            'objectIds' => $solutionObjectId
        ]);

        $relationSolutionAccountResponse = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->put(env('BASE_URL_API') . "/api/data/solutions/{$solutionObjectId}/ownerData", [
            'objectIds' => $accountId
        ]);

        ////////////
        $reportObjectId = $slug;
        Log::info('Response from Backendless:', [
            'slug_reportId' => $solutionObjectId,
        ]);
        $relationReportSolutionResponse = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->put(env('BASE_URL_API') . "/api/data/reports/{$reportObjectId}/solutionReportList", [
            'objectIds' => $solutionObjectId
        ]);

        $relationSolutionReportResponse = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->put(env('BASE_URL_API') . "/api/data/solutions/{$solutionObjectId}/reportData", [
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

    public function updateSolutionStatus(Request $request, $reportIdSlug, $solutionIdSlug)
    {
        // Validasi input dari request
        $request->validate([
            'change-solution-status' => 'required|string|in:Selected,In Progress,Completed',
        ]);

        // Panggil API untuk mengupdate status solusi
        $updateSolution = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->put(env('BASE_URL_API') . "/api/data/solutions/{$solutionIdSlug}", [
            'status' => $request->input('change-solution-status'),
        ]);

        // Tanggapan berdasarkan hasil respons API
        if ($updateSolution->successful()) {
            return back()->with('success', 'Status solusi berhasil diperbarui');
        } else {
            // Log detail respons API
            Log::error('Gagal memperbarui status solusi', [
                'response_status' => $updateSolution->status(), // HTTP status code dari API
                'response_body' => $updateSolution->body(), // Body respons dari API
                'request_data' => $request->all() // Data yang dikirim ke API
            ]);
            return back()->withErrors(['error' => 'Terjadi kesalahan saat merubah status solusi']);
        }
    }
}
