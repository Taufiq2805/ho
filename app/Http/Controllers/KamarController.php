<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\TipeKamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tipeKamar = TipeKamar::all();

        $query = Kamar::with('tipe');

        if ($request->filled('tipe_id')) {
            $query->where('tipe_id', $request->tipe_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kamar = $query->get();

        return view('admin.kamar.index', compact('kamar', 'tipeKamar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipeKamar = TipeKamar::all();
        return view('admin.kamar.create', compact('tipeKamar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_kamar' => 'required|string|unique:kamars,nomor_kamar',
            'tipe_id' => 'required|exists:tipe_kamars,id',
            'status' => 'required|in:tersedia,terisi,dibersihkan,maintenance',
        ]);

        Kamar::create([
            'nomor_kamar' => $request->nomor_kamar,
            'tipe_id' => $request->tipe_id,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kamar $kamar)
    {
        $tipeKamar = TipeKamar::all();
        return view('admin.kamar.edit', compact('kamar', 'tipeKamar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kamar $kamar)
    {
        $request->validate([
            'nomor_kamar' => 'required|string|unique:kamars,nomor_kamar,' . $kamar->id,
            'tipe_id' => 'required|exists:tipe_kamars,id',
            'status' => 'required|in:tersedia,terisi,dibersihkan,maintenance',
        ]);

        $kamar->update([
            'nomor_kamar' => $request->nomor_kamar,
            'tipe_id' => $request->tipe_id,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kamar $kamar)
    {
        $kamar->delete();

        return redirect()
            ->route('admin.kamar.index')
            ->with('success', 'Kamar berhasil dihapus.');
    }
}
