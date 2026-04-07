<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\Reservasi;
use Carbon\Carbon;

class ResepsionisDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // 🔹 DATA KAMAR
        $totalKamar       = Kamar::count();
        $kamarTersedia    = Kamar::where('status', 'tersedia')->count();
        $kamarTerisi      = Kamar::where('status', 'terisi')->count();
        $kamarMaintenance = Kamar::where('status', 'maintenance')->count();

        // 🔹 DATA RESERVASI
        $reservasiHariIni = Reservasi::whereDate('tanggal_checkin', $today)->count();

        // 🔹 LIST CHECK-IN HARI INI (UNTUK PANEL)
        $checkins = Reservasi::with('kamar')
            ->whereDate('tanggal_checkin', $today)
            ->orderBy('created_at', 'desc')
            ->get();

        // 🔹 SEMUA KAMAR (UNTUK GRID STATUS)
        $kamars = Kamar::orderBy('nomor_kamar', 'asc')->get();

        return view('resepsionis.index', compact(
            'totalKamar',
            'kamarTersedia',
            'kamarTerisi',
            'kamarMaintenance',
            'reservasiHariIni',
            'checkins',
            'kamars'
        ));
    }
}