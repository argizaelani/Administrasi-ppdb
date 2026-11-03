@extends('layouts.app')

@section('content')
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
                
                <!-- Header dengan Ikon Silang Kanan Atas -->
                <div class="card-header text-center bg-white pt-4 pb-2 border-0 position-relative">
                    <a href="{{ route('pendaftaran.index') }}" class="btn-close position-absolute" style="top: 20px; right: 20px;" aria-label="Close" title="Tutup dan Kembali"></a>
                    
                    <h4 class="fw-bold" style="color: #ff7800;">Input Data Pendaftar Baru</h4>
                    <p class="text-muted mb-0">Pastikan data yang dimasukkan sesuai dengan dokumen asli.</p>
                </div>

                <div class="card-body px-5 pb-5 pt-4">
                    <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Nama Calon Siswa</label>
                            <input type="text" name="nama_calon_siswa" class="form-control" style="border-radius: 10px;" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-secondary">Nama Orang Tua / Wali</label>
                                <input type="text" name="nama_orang_tua" class="form-control" style="border-radius: 10px;" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-secondary">Nomor HP / Telepon</label>
                                <input type="text" name="nomor_orang_tua" class="form-control" style="border-radius: 10px;" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Rekomendasi Oleh <span class="text-muted fw-normal">(Opsional)</span></label>
                            <input type="text" name="nama_rekomendasi" class="form-control" style="border-radius: 10px;">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Unggah Bukti Pendaftaran</label>
                            <input type="file" name="bukti_pendaftaran" class="form-control" style="border-radius: 10px;" required accept="image/png, image/jpeg, image/jpg">
                            <small class="text-muted">Format: JPG, JPEG, PNG (Maks 2MB)</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Catatan Lain <span class="text-muted fw-normal">(Opsional)</span></label>
                            <textarea name="catatan_lain" class="form-control" rows="3" style="border-radius: 10px;"></textarea>
                        </div>

                        <!-- Tombol Simpan (Tanpa tombol Batal di sebelahnya) -->
                        <div class="d-flex justify-content-end mt-2">
                            <button type="submit" class="btn btn-primary px-4 py-2" style="border-radius: 8px;">
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection