@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-header d-flex justify-content-between align-items-center bg-white" style="border-radius: 15px 15px 0 0; padding: 15px 20px;">
            <h5 class="mb-0 fw-bold" style="color: #ff7800;">Data Pendaftar PPDB</h5>
            
            <div class="d-flex w-75 justify-content-end">
                <input type="text" id="searchInput" class="form-control form-control-sm me-2 w-50" placeholder="🔍 Cari nama siswa / orang tua..." style="border-radius: 8px;">
                
                <button type="button" class="btn btn-sm btn-success text-nowrap me-2" data-bs-toggle="modal" data-bs-target="#cetakPdfModal" style="border-radius: 8px;">
                    📄 Cetak PDF
                </button>
                
                <a href="{{ route('pendaftaran.create') }}" class="btn btn-sm btn-primary text-nowrap" style="border-radius: 8px;">➕ Tambah Data</a>
            </div>
        </div>
        
        <div class="card-body table-responsive p-0">
            <table class="table table-hover mb-0" id="pendaftarTable">
                <thead class="text-center align-middle" style="background-color: #ffe8d6; color: #d15c00;">
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Nama Siswa</th>
                        <th width="20%">Data Orang Tua</th>
                        <th width="15%">Waktu Daftar</th>
                        <th width="10%">Bukti Pendaftaran</th>
                        <th width="15%">Catatan</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody class="align-middle text-center bg-white">
                    @foreach ($pendaftarans as $index => $pendaftar)
                    <tr class="searchable-row">
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td class="fw-bold">{{ $pendaftar->nama_calon_siswa }}</td>
                        <td>
                            {{ $pendaftar->nama_orang_tua }}<br>
                            <small class="text-muted">📞 {{ $pendaftar->nomor_orang_tua }}</small>
                        </td>
                        <td>
                            {{ $pendaftar->created_at->format('d M Y') }}<br>
                            <small class="text-muted">🕒 {{ $pendaftar->created_at->format('H:i') }} WIB</small>
                        </td>
                        <td class="text-center">
                            <a href="{{ asset('storage/' . $pendaftar->bukti_pendaftaran) }}" target="_blank" class="btn btn-sm btn-info text-white" style="border-radius: 6px;">Lihat</a>
                        </td>
                        <td><small>{{ $pendaftar->catatan_lain ?? '-' }}</small></td>
                        <td class="text-center">
   <td class="text-center">
    <!-- Ganti flex-wrap menjadi flex-nowrap agar sejajar ke samping -->
    <div class="d-flex justify-content-center flex-nowrap gap-2">
        <!-- Ikon Edit (Pensil) -->
        <button type="button" class="btn btn-sm btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#editModal{{ $pendaftar->id }}" style="border-radius: 6px;" title="Edit Data">
            <i class="bi bi-pencil-square"></i>
        </button>
        
        <!-- Ikon Kwitansi (Printer) -->
        <a href="{{ route('pendaftaran.cetak', $pendaftar->id) }}" target="_blank" class="btn btn-sm btn-secondary" style="border-radius: 6px;" title="Cetak Kwitansi">
            <i class="bi bi-printer"></i>
        </a>
        
        <!-- Ikon Hapus (Tempat Sampah) -->
        <form action="{{ route('pendaftaran.destroy', $pendaftar->id) }}" method="POST" class="m-0 p-0" onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" style="border-radius: 6px;" title="Hapus Data">
                <i class="bi bi-trash"></i>
            </button>
        </form>
    </div>
</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-light" style="border-radius: 0 0 15px 15px;">
            <small class="text-muted fw-bold">Total Pendaftar: {{ count($pendaftarans) }} orang</small>
        </div>
    </div>
</div>

<!-- ================= MODAL EDIT DATA (Dipindah ke luar tabel) ================= -->
@foreach ($pendaftarans as $pendaftar)
<div class="modal fade" id="editModal{{ $pendaftar->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header bg-light border-0" style="border-radius: 15px 15px 0 0;">
                <h5 class="modal-title fw-bold" style="color: #ff7800;">Edit Data: {{ $pendaftar->nama_calon_siswa }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pendaftaran.update', $pendaftar->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-secondary fw-bold">Nama Calon Siswa</label>
                            <input type="text" name="nama_calon_siswa" class="form-control" value="{{ $pendaftar->nama_calon_siswa }}" style="border-radius: 8px;" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary fw-bold">Nama Orang Tua</label>
                            <input type="text" name="nama_orang_tua" class="form-control" value="{{ $pendaftar->nama_orang_tua }}" style="border-radius: 8px;" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-secondary fw-bold">No. Telepon / HP</label>
                            <input type="text" name="nomor_orang_tua" class="form-control" value="{{ $pendaftar->nomor_orang_tua }}" style="border-radius: 8px;" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-secondary fw-bold">Rekomendasi Oleh (Opsional)</label>
                            <input type="text" name="nama_rekomendasi" class="form-control" value="{{ $pendaftar->nama_rekomendasi }}" style="border-radius: 8px;">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-secondary fw-bold d-block">Bukti Pendaftaran Saat Ini</label>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ asset('storage/' . $pendaftar->bukti_pendaftaran) }}" alt="Bukti" class="img-thumbnail" width="120" style="border-radius: 8px;">
                                <div>
                                    <small class="text-muted d-block mb-1">Ganti file bukti (biarkan kosong jika tidak diubah)</small>
                                    <input type="file" name="bukti_pendaftaran" class="form-control form-control-sm" style="border-radius: 8px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label class="form-label text-secondary fw-bold">Catatan Tambahan</label>
                            <textarea name="catatan_lain" class="form-control" rows="2" style="border-radius: 8px;">{{ $pendaftar->catatan_lain }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-primary px-4" style="border-radius: 8px;">Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- ================= MODAL CETAK RENTANG TANGGAL ================= -->
<div class="modal fade" id="cetakPdfModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header text-white border-0" style="background-color: #198754; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title fw-bold">Cetak Rekap Data (PDF)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pendaftaran.cetak-pdf') }}" method="GET">
                <div class="modal-body">
                    <p class="text-muted small mb-4">Pilih rentang tanggal pendaftaran untuk ditarik menjadi laporan PDF.</p>
                    
                    <div class="mb-3">
                        <label class="fw-bold text-secondary">Dari Tanggal</label>
                        <input type="date" name="tanggal_awal" class="form-control" value="{{ date('Y-m-d') }}" style="border-radius: 8px;" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="fw-bold text-secondary">Sampai Tanggal</label>
                        <input type="date" name="tanggal_akhir" class="form-control" value="{{ date('Y-m-d') }}" style="border-radius: 8px;" required>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-success px-4" style="border-radius: 8px;">Download Laporan PDF</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= SCRIPT PENCARIAN REAL-TIME ================= -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const rows = document.querySelectorAll('#pendaftarTable .searchable-row');

    searchInput.addEventListener('keyup', function(event) {
        const query = event.target.value.toLowerCase();
        
        rows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            if (rowText.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
@endsection