<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Informasi;

class InformasiController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'data'   => Informasi::all()
        ]);
    }

    public function show($id)
    {
        $informasi = Informasi::find($id);

        if (!$informasi) {
            return response()->json([
                'status'  => false,
                'message' => 'Informasi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => $informasi
        ]);
    }
}