<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ChatbotController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/clear-cache', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    return 'Cache berhasil dibersihkan! Silakan buka kembali halaman utama.';
});

Route::post('/api/chatbot/conversations', [ChatbotController::class, 'createConversation']);
Route::post('/api/chatbot/chat', [ChatbotController::class, 'sendMessage']);
