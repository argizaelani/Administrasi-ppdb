<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi - {{ $pendaftaran->nama_calon_siswa }}</title>
    <style>
        /* Desain khusus agar rapi saat diprint di kertas A4 */
        body { 
            font-family: 'Times New Roman', Times, serif; 
            color: #000; 
            background: #fff; 
            line-height: 1.5; 
            font-size: 14px;
        }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 25px; }
        .header h2, .header h3 { margin: 0; padding: 2px; }
        .content { margin-left: 30px; margin-bottom: 20px; }
        .row-data { display: flex; margin-bottom: 12px; }
        .label { width: 30%; font-weight: bold; }
        .value { width: 70%; text-transform: capitalize; }
        .ttd-container { display: flex; justify-content: space-between; margin-top: 60px; text-align: center; }
        .ttd-box { width: 40%; }
        
        /* Tombol ini akan hilang otomatis di kertas saat diprint */
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Tombol Bantuan (Tidak ikut terprint) -->
        <div class="no-print" style="margin-bottom: 20px; text-align: right;">
            <button onclick="window.print()" style="padding: 8px 15px; background: #ff7800; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">🖨️ Cetak Sekarang</button>
            <button onclick="window.close()" style="padding: 8px 15px; background: #6c757d; color: white; border: none; border-radius: 5px; cursor: pointer; margin-left: 5px;">Tutup</button>
        </div>

        <!-- Kop Surat -->
        <div class="header">
            <h2>SMK FATAHILLAH CILEUNGSI</h2>
            <h2>PANITIA SPMB</h2>
            <h3>Bukti Penerimaan Pendaftaran</h3>
        </div>

        <p>Telah diterima pendaftaran calon peserta didik baru dengan rincian sebagai berikut:</p>

        <!-- Detail Data Siswa -->
        <div class="content">
            <div class="row-data">
                <div class="label">No. Pendaftaran</div>
                <div class="value">: <strong>PPDB-{{ str_pad($pendaftaran->id, 4, '0', STR_PAD_LEFT) }}</strong></div>
            </div>
            <div class="row-data">
                <div class="label">Tanggal Daftar</div>
                <div class="value">: {{ $pendaftaran->created_at->format('d F Y (H:i)') }} WIB</div>
            </div>
            <div class="row-data">
                <div class="label">Nama Calon Siswa</div>
                <div class="value">: <strong style="text-transform: uppercase; font-size: 16px;">{{ $pendaftaran->nama_calon_siswa }}</strong></div>
            </div>
            <div class="row-data">
                <div class="label">Nama Orang Tua/Wali</div>
                <div class="value">: {{ $pendaftaran->nama_orang_tua }}</div>
            </div>
            <div class="row-data">
                <div class="label">No. Telepon / HP</div>
                <div class="value">: {{ $pendaftaran->nomor_orang_tua }}</div>
            </div>
            <div class="row-data">
                <div class="label">Rekomendasi Oleh</div>
                <div class="value">: {{ $pendaftaran->nama_rekomendasi ?? '-' }}</div>
            </div>
        </div>

        <p>Pendaftaran telah divalidasi dan dinyatakan <strong>VALID</strong>. Bukti ini harap disimpan dengan baik sebagai persyaratan daftar ulang.</p>

        <!-- Kolom Tanda Tangan -->
        <div class="ttd-container">
            <div class="ttd-box">
                <p>Menyerahkan,</p>
                <br><br><br><br>
                <p><strong>( {{ $pendaftaran->nama_orang_tua }} )</strong><br>Orang Tua / Wali Siswa</p>
            </div>
            <div class="ttd-box">
                <p>Cileungsi, {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d F Y') }}</p>
                <p>Panitia Penerima,</p>
                <br><br><br><br>
                <p><strong>( {{ $pendaftaran->nama_panitia }} )</strong></p>
            </div>
        </div>
    </div>

    <!-- Script JavaScript untuk memunculkan dialog Print otomatis -->
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>