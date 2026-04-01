<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Kamar;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    public function index()
    {
        // Hanya tampilkan maintenance yang masih dalam proses (status != tersedia)
        $maintenances = Maintenance::with(['kamar', 'user', 'pengeluaran'])
            ->where('status', '!=', 'tersedia')
            ->latest()
            ->get();
        $kamars = Kamar::all();

        return view('housekeeping.maintenance.index', compact('maintenances', 'kamars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kamar_id' => 'required|exists:kamars,id',
            'tanggal'  => 'required|date',
            'status'   => 'required|in:tersedia,terisi,dibersihkan,maintenance',
            'catatan'  => 'nullable|string',
        ]);

        // Simpan maintenance
        $maintenance = Maintenance::create([
            'kamar_id' => $request->kamar_id,
            'user_id'  => Auth::id(),
            'tanggal'  => $request->tanggal,
            'status'   => $request->status ?? 'maintenance',
            'catatan'  => $request->catatan,
        ]);

        // Sinkron status kamar
        $maintenance->kamar->update(['status' => $maintenance->status]);

        // 🔥 AUTO SPLIT CATATAN JADI BANYAK PENGELUARAN
        if (!empty($maintenance->catatan)) {

            $items = preg_split('/\r\n|\r|\n/', $maintenance->catatan);

            foreach ($items as $item) {

                $item = trim($item);
                if (!$item) continue;

                // Ambil angka jumlah
                preg_match('/(\d+)/', $item, $matches);
                $jumlah = isset($matches[1]) ? (int)$matches[1] : 1;

                // Hapus angka dari nama barang
                $nama_barang = trim(preg_replace('/\d+\s*(pcs|unit)?/i', '', $item));

                Pengeluaran::create([
                    'maintenance_id'      => $maintenance->id,
                    'kamar_id'            => $maintenance->kamar_id,
                    'tanggal_pengeluaran' => now(),
                    'nama_barang'         => $nama_barang ?: $item,
                    'jumlah_barang'       => $jumlah,
                    'harga_satuan'        => 0,
                    'total_harga'         => 0,
                    'created_by'          => Auth::id(),
                ]);
            }
        }

        return redirect()->route('housekeeping.maintenance.index')
            ->with('success', 'Maintenance berhasil ditambahkan.');
    }

    public function update(Request $request, Maintenance $maintenance)
    {
        $request->validate([
            'kamar_id' => 'required|exists:kamars,id',
            'tanggal'  => 'required|date',
            'status'   => 'required|in:tersedia,terisi,dibersihkan,maintenance',
            'catatan'  => 'nullable|string',
        ]);

        $maintenance->update([
            'kamar_id' => $request->kamar_id,
            'tanggal'  => $request->tanggal,
            'status'   => $request->status,
            'catatan'  => $request->catatan,
        ]);

        // Update status kamar jika selesai
        if ($request->status === 'tersedia') {
            $maintenance->kamar->update(['status' => 'tersedia']);
        }

        // 🔥 HAPUS pengeluaran lama lalu buat ulang sesuai catatan baru
        Pengeluaran::where('maintenance_id', $maintenance->id)->delete();

        if (!empty($request->catatan)) {

            $items = preg_split('/\r\n|\r|\n/', $request->catatan);

            foreach ($items as $item) {

                $item = trim($item);
                if (!$item) continue;

                preg_match('/(\d+)/', $item, $matches);
                $jumlah = isset($matches[1]) ? (int)$matches[1] : 1;

                $nama_barang = trim(preg_replace('/\d+\s*(pcs|unit)?/i', '', $item));

                Pengeluaran::create([
                    'maintenance_id'      => $maintenance->id,
                    'kamar_id'            => $maintenance->kamar_id,
                    'tanggal_pengeluaran' => now(),
                    'nama_barang'         => $nama_barang ?: $item,
                    'jumlah_barang'       => $jumlah,
                    'harga_satuan'        => 0,
                    'total_harga'         => 0,
                    'created_by'          => Auth::id(),
                ]);
            }
        }

        return redirect()->route('housekeeping.maintenance.index')
            ->with('success', 'Maintenance berhasil diperbarui.');
    }

    public function destroy(Maintenance $maintenance)
    {
        Pengeluaran::where('maintenance_id', $maintenance->id)->delete();
        $maintenance->delete();

        return redirect()->route('housekeeping.maintenance.index')
            ->with('success', 'Maintenance berhasil dihapus.');
    }

    public function updateStatus($id)
    {
        $maintenance = Maintenance::findOrFail($id);

        $maintenance->update(['status' => 'tersedia']);
        $maintenance->kamar->update(['status' => 'tersedia']);

        return back()->with('success', 'Maintenance selesai. Kamar kembali tersedia.');
    }

    /**
     * Update only the "catatan" field via AJAX and sync pengeluaran
     */
    public function updateCatatan(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:maintenances,id',
            'catatan' => 'nullable|string',
        ]);

        $maintenance = Maintenance::findOrFail($request->id);

        $maintenance->update(['catatan' => $request->catatan]);

        // Hapus pengeluaran lama
        Pengeluaran::where('maintenance_id', $maintenance->id)->delete();

        if (!empty($request->catatan)) {
            $items = preg_split('/\r\n|\r|\n/', $request->catatan);

            foreach ($items as $item) {
                $item = trim($item);
                if (!$item) continue;

                preg_match('/(\d+)/', $item, $matches);
                $jumlah = isset($matches[1]) ? (int)$matches[1] : 1;

                $nama_barang = trim(preg_replace('/\d+\s*(pcs|unit)?/i', '', $item));

                Pengeluaran::create([
                    'maintenance_id'      => $maintenance->id,
                    'kamar_id'            => $maintenance->kamar_id,
                    'tanggal_pengeluaran' => now(),
                    'nama_barang'         => $nama_barang ?: $item,
                    'jumlah_barang'       => $jumlah,
                    'harga_satuan'        => 0,
                    'total_harga'         => 0,
                    'created_by'          => Auth::id(),
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Catatan diperbarui']);
    }
}
