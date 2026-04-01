@extends('layouts.housekeeping')

@section('title', 'Data Pengeluaran')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Manajemen Pengeluaran</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tombol Tambah -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
        + Tambah Pengeluaran
    </button>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Kamar</th>
                    <th>Keterangan</th>
                    <th>Tanggal Pengeluaran</th>
                    <th>Jumlah Pengeluaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse($pengeluarans as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->user->name ?? '-' }}</td>
                <td>{{ $p->kamar->nomor_kamar ?? '-' }}</td>

                <!-- ✅ Multi baris otomatis -->
                <td>
                    @php
                        $items = explode("\n", $p->nama_barang);
                    @endphp

                    @foreach($items as $item)
                        <div>{{ $item }}</div>
                    @endforeach

                    ({{ $p->jumlah_barang }} pcs)
                </td>

                <td>{{ \Carbon\Carbon::parse($p->tanggal_pengeluaran)->format('d-m-Y') }}</td>
                <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>

                <td>
                    <button class="btn btn-sm btn-success"
                        data-bs-toggle="modal"
                        data-bs-target="#modalEdit-{{ $p->id }}">
                        Ubah
                    </button>

                    <form action="{{ route('housekeeping.pengeluaran.destroy', $p->id) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Yakin hapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted">
                    Belum ada data pengeluaran.
                </td>
            </tr>
            @endforelse
            </tbody>

        </table>
    </div>
</div>

{{-- ================= MODAL EDIT ================= --}}
@foreach($pengeluarans as $p)
<div class="modal fade" id="modalEdit-{{ $p->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{ route('housekeeping.pengeluaran.update', $p->id) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="kamar_id" value="{{ $p->kamar_id }}">
                <input type="hidden" name="maintenance_id" value="{{ $p->maintenance_id }}">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Pengeluaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal_pengeluaran"
                               class="form-control"
                               value="{{ $p->tanggal_pengeluaran }}">
                    </div>

                    <div class="col-md-6">
                        <label>Nama Barang</label>
                        <input type="text" name="nama_barang"
                               class="form-control"
                               value="{{ $p->nama_barang }}">
                    </div>

                    <div class="col-md-4">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah_barang"
                               class="form-control jumlah"
                               value="{{ $p->jumlah_barang }}">
                    </div>

                    <div class="col-md-4">
                        <label>Harga</label>
                        <input type="number" name="harga_satuan"
                               class="form-control harga"
                               value="{{ $p->harga_satuan }}">
                    </div>

                    <div class="col-md-4">
                        <label>Total</label>
                        <input type="number" name="total_harga"
                               class="form-control total"
                               value="{{ $p->total_harga }}" readonly>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach


{{-- ================= MODAL TAMBAH ================= --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="{{ route('housekeeping.pengeluaran.store') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pengeluaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label>Kamar</label>
                        <select name="kamar_id" class="form-select">
                            @foreach($kamars as $k)
                                <option value="{{ $k->id }}">{{ $k->nomor_kamar }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal_pengeluaran" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label>Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label>Jumlah</label>
                        <input type="number" name="jumlah_barang" class="form-control jumlah">
                    </div>

                    <div class="col-md-3">
                        <label>Harga</label>
                        <input type="number" name="harga_satuan" class="form-control harga">
                    </div>

                    <div class="col-md-4">
                        <label>Total</label>
                        <input type="number" name="total_harga" class="form-control total" readonly>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function setupAutoTotal(modalElement) {
        const jumlahInput = modalElement.querySelector('input[name="jumlah_barang"]');
        const hargaInput = modalElement.querySelector('input[name="harga_satuan"]');
        const totalInput = modalElement.querySelector('input[name="total_harga"]');

        if (!jumlahInput || !hargaInput || !totalInput) return;

        function updateTotal() {
            const jumlah = parseFloat(jumlahInput.value) || 0;
            const harga = parseFloat(hargaInput.value) || 0;
            totalInput.value = jumlah * harga;
        }

        jumlahInput.addEventListener('input', updateTotal);
        hargaInput.addEventListener('input', updateTotal);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const modalTambah = document.getElementById('modalTambah');
        if (modalTambah) {
            modalTambah.addEventListener('shown.bs.modal', () => setupAutoTotal(modalTambah));
        }

        document.querySelectorAll('[id^="modalEdit-"]').forEach(modal => {
            modal.addEventListener('shown.bs.modal', () => setupAutoTotal(modal));
        });
    });
</script>
@endpush
