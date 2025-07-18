<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Log;  

class FileController extends Controller
{
    public function downloadDocument(Request $request, $filename)
    {
        Log::info('Attempting download for: ' . $filename);
        Log::info('Request Headers: ' . json_encode($request->headers->all())); // <-- TAMBAHKAN INI
        if (Auth::guard('api')->check()) { // Pastikan Anda menggunakan guard 'api' jika itu yang digunakan JWT
            Log::info('Auth Check: TRUE. User ID: ' . Auth::guard('api')->id());
        } else {
            Log::warning('Auth Check: FALSE. Possible JWT failure.');
        }

        $path = 'documents/daftar_pelatihan/' . $filename;
        if (Storage::disk('public')->exists($path)) {
            return response()->file(Storage::disk('public')->path($path));
        }
        return response()->json(['message' => 'File not found'], 404);
    }
}