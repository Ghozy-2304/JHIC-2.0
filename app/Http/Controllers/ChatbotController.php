<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function sendMessage(Request $request)
    {
        $userMessage = $request->input('message');
        $fastapiUrl = env('FASTAPI_CHATBOT_URL') . '/api/chat'; // Sesuaikan endpoint FastAPI Anda

        // Kirim request ke FastAPI di Render
        $response = Http::post($fastapiUrl, [
            'message' => $userMessage,
        ]);

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Gagal terhubung ke chatbot backend'], 500);
    }
}
