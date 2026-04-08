<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use App\Models\Kamar;
use App\Models\Makanan;
use App\Models\Maintenance;
use App\Models\ReportSewa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    // GET /api/reservasi
    public function index()
    {
        $reservasis = Reservasi::with(['kamar.tipe', 'makanans'])->latest()->get();

        foreach ($reservasis as $reservasi) {
            if ($reservasi->status === 'terisi' && Carbon::now()->gt($reservasi->tanggal_checkout)) {
                $reservasi->kamar->update(['status' => 'maintenance']);
                $reservasi->update(['status' => 'selesai']);

                $alreadyExists = Maintenance::where('kamar_id', $reservasi->kamar_id)
                    ->whereDate('tanggal', Carbon::now()->toDateString())
                    ->exists();

                if (!$alreadyExists) {
                    Maintenance::create([
                        'kamar_id' => $reservasi->kamar_id,
                        'user_id'  => auth()->id(),
                        'tanggal'  => Carbon::now()->toDateString(),
                        'status'   => 'maintenance',
                        'catatan'  => null,
                    ]);
                }
            }
        }

        return response()->json($reservasis);
    }

    // GET /api/reservasi/{id}
    public function show($id)
    {
        $reservasi = Reservasi::with(['kamar.tipe', 'makanans'])->findOrFail($id);
        return response()->json($reservasi);
    }

    // POST /api/reservasi
    public function store(Request $request)
    {
        $request->validate([
            'kamar_id'         => 'required|exists:kamars,id',
            'nama_tamu'        => 'required|string',
            'tanggal_checkin'  => 'required|date',
            'tanggal_checkout' => 'required|date|after_or_equal:tanggal_checkin',
            'makanan_id'       => 'nullable|array',
            'makanan_id.*'     => 'exists:makanans,id',
        ]);

        $kamar = Kamar::with('tipe')->findOrFail($request->kamar_id);
        $durasi = Carbon::parse($request->tanggal_checkin)
                        ->diffInDays(Carbon::parse($request->tanggal_checkout));
        if ($durasi === 0) $durasi = 1;

        $totalKamar = $durasi * $kamar->tipe->harga;

        $totalMakanan = 0;
        if ($request->makanan_id) {
            $makanans = Makanan::whereIn('id', $request->makanan_id)->get();
            foreach ($makanans as $m) {
                $totalMakanan += $m->harga;
            }
        }

        $reservasi = Reservasi::create([
            'kamar_id'         => $request->kamar_id,
            'nama_tamu'        => $request->nama_tamu,
            'tanggal_checkin'  => $request->tanggal_checkin,
            'tanggal_checkout' => $request->tanggal_checkout,
            'status'           => 'terisi',
            'total'            => $totalKamar + $totalMakanan,
        ]);

        $kamar->update(['status' => 'terisi']);

        if ($request->makanan_id) {
            foreach ($request->makanan_id as $makananId) {
                $reservasi->makanans()->attach($makananId, ['qty' => 1]);
            }
        }

        return response()->json($reservasi->load(['kamar.tipe', 'makanans']), 201);
    }

    // PUT /api/reservasi/{id}/checkout
    public function checkout($id)
    {
        $reservasi = Reservasi::with('kamar.tipe', 'makanans')->findOrFail($id);

        $checkin  = Carbon::parse($reservasi->tanggal_checkin);
        $checkout = Carbon::parse($reservasi->tanggal_checkout);
        $lama = $checkin->diffInDays($checkout) ?: 1;

        $totalKamar   = ($reservasi->kamar->tipe->harga ?? 0) * $lama;
        $totalMakanan = 0;
        foreach ($reservasi->makanans as $m) {
            $totalMakanan += ($m->pivot->qty ?? 1) * ($m->harga ?? 0);
        }

        ReportSewa::updateOrCreate(
            ['id_reservasi' => $reservasi->id],
            ['total' => $totalKamar + $totalMakanan]
        );

        $kamarId = $reservasi->kamar_id;
        $reservasi->kamar->update(['status' => 'maintenance']);
        $reservasi->delete();

        $existing = Maintenance::where('kamar_id', $kamarId)
            ->whereDate('tanggal', now()->toDateString())
            ->first();

        if (!$existing) {
            Maintenance::create([
                'kamar_id' => $kamarId,
                'user_id'  => auth()->id(),
                'tanggal'  => now()->toDateString(),
                'status'   => 'maintenance',
                'catatan'  => null,
            ]);
        }

        return response()->json(['message' => 'Checkout berhasil. Kamar masuk maintenance.']);
    }
}