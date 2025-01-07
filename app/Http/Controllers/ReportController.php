<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReportController extends Controller
{
    public function show($slug)
    {
        // Fetch data dari API menggunakan slug
        $apiUrl = "https://kindlyblade-us.backendless.app/api/data/reports/{$slug}";

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
}
