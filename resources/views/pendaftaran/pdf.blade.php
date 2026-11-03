<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Pendaftaran PPDB</title>
    <style>
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            font-size: 11px; 
            color: #333;
        }
        .header { 
            text-align: center; 
            margin-bottom: 25px; 
            border-bottom: 2px solid #000; 
            padding-bottom: 15px; 
        }
        .header h2, .header h3 { 
            margin: 0; 
            padding: 3px; 
        }
        .header p { 
            margin: 8px 0 0 0; 
            font-size: 13px; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
        }
        th, td { 
            border: 1px solid #555; 
            padding: 6px; 
            vertical-align: top;
        }
        th { 
            background-color: #f2f2f2; 
            text-align: center; 
            font-weight: bold;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .footer { 
            margin-top: 40px; 
            width: 100%;
        }
        .ttd-box { 
            float: right; 
            width: 250px; 
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>LAPORAN REKAPITULASI PENDAFTARAN SISWA BARU</h2>
        <h2>SMK FATAHILLAH CILEUNGSI</h2>
        <h3>PANITIA PPDB TAHUN 2027-2028</h3>
        <p>
            Periode Pendaftaran: <strong>{{ \Carbon\Carbon::parse($tanggalAwal)->format('d F Y') }}</strong> 
            s/d 
            <strong>{{ \Carbon\Carbon::parse($tanggalAkhir)->format('d F Y') }}</strong>
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="15%">Waktu Daftar</th>
                <th width="20%">Nama Calon Siswa</th>
                <th width="18%">Nama Orang Tua</th>
                <th width="13%">No. Telp / HP</th>
                <th width="15%">Rekomendasi Oleh</th>
                <th width="15%">Panitia Penerima</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendaftarans as $index => $pendaftar)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">
                    {{ $pendaftar->created_at->format('d/m/Y') }}<br>
                    {{ $pendaftar->created_at->format('H:i') }} WIB
                </td>
                <td><strong>{{ $pendaftar->nama_calon_siswa }}</strong></td>
                <td>{{ $pendaftar->nama_orang_tua }}</td>
                <td class="text-center">{{ $pendaftar->nomor_orang_tua }}</td>
                <td>{{ $pendaftar->nama_rekomendasi ?? '-' }}</td>
                <td>{{ $pendaftar->nama_panitia }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 15px; font-weight: bold;">
        Total Pendaftar pada periode ini: {{ count($pendaftarans) }} Siswa
    </div>

    <!-- Kolom Tanda Tangan untuk Dokumen Resmi -->
    <div class="footer">
        <div class="ttd-box">
            <p>Cileungsi, {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d F Y') }}</p>
            <p>Ketua Panitia PPDB,</p>
            <br><br><br><br>
            <p><strong>_________________________</strong></p>
        </div>
    </div>

</body>
</html>