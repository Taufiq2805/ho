<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;

class ReservasiController extends Controller
{
    public function index()
    {
        $data = Reservasi::with(['kamar','resepsionis'])->latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Data reservasi',
            'data' => $data
        ]);
    }
}
