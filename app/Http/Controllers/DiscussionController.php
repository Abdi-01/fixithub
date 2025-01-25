<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DiscussionController extends Controller
{
    public function cretaeMessage(Request $request, $slug)
    {
        // #input validation
        $validated = $request->validate([
            'message' => 'required',
        ]);

        $email = session('user') ? session('user')['email'] : null;

        // #data payload
        $payload = [
            'email' => $email,
            'message' => $validated['message'],
        ];


        // #send request to API
        $response = Http::post(env('BASE_URL_API') . '/api/data/discussions', $payload);

        // Ambil ID discuss message yang baru dibuat
        $discussObjectId = $response->json()['objectId'];

        $reportObjectId = $slug;

        $relationReportDiscussResponse = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->put(env('BASE_URL_API') . "/api/data/reports/{$reportObjectId}/discussionMessages", [
            'objectIds' => $discussObjectId
        ]);


        // #handling response
        if ($response->successful() && $relationReportDiscussResponse->successful()) {
            return back()->with('success', 'Pesan diskusi berhasil dibuat');
        } else {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat membuat pesan']);
        }
    }
}
