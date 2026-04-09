<?php

use App\Models\Kamar;
use App\Models\TipeKamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReservasiController;
use App\Http\Controllers\Api\InformasiController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/kamar/stats', function () {
        return response()->json([
            'status' => true,
            'data'   => [
                'total_kamar'    => Kamar::count(),
                'kamar_terisi'   => Kamar::where('status', 'terisi')->count(),
                'kamar_tersedia' => Kamar::where('status', 'tersedia')->count(),
                'dibersihkan'    => Kamar::where('status', 'dibersihkan')->count(),
                'maintenance'    => Kamar::where('status', 'maintenance')->count(),
            ]
        ]);
    });

    Route::get('/kamar/tersedia', function () {
        return response()->json([
            'status' => true,
            'data'   => Kamar::with('tipe')
                            ->where('status', 'tersedia')
                            ->get()
        ]);
    });

    Route::get('/kamar', function () {
        return response()->json([
            'status' => true,
            'data'   => Kamar::all()
        ]);
    });

    Route::get('/tipe-kamar', function () {
        return response()->json([
            'status' => true,
            'data'   => TipeKamar::all()
        ]);
    });

    // Reservasi
    Route::get('/reservasi', [ReservasiController::class, 'index']);
    Route::get('/reservasi/{id}', [ReservasiController::class, 'show']);
    Route::post('/reservasi', [ReservasiController::class, 'store']);
    Route::put('/reservasi/{id}/checkout', [ReservasiController::class, 'checkout']);
});
// Informasi
Route::get('/informasi', [InformasiController::class, 'index']);
Route::get('/informasi/{id}', [InformasiController::class, 'show']);