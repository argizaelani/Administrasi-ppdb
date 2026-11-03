<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PendaftaranController extends Controller
{
    // 1. Tampilkan Halaman Utama (Tabel)
    public function index()
    {
        $pendaftarans = Pendaftaran::latest()->get();
        return view('pendaftaran.index', compact('pendaftarans'));
    }

    // 2. Tampilkan Form Tambah Data
    public function create()
    {
        return view('pendaftaran.create');
    }

    // 3. Proses Simpan Data Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_calon_siswa' => 'required|string|max:255',
            'nama_orang_tua' => 'required|string|max:255',
            'nomor_orang_tua' => 'required|string|max:20',
            'bukti_pendaftaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $file = $request->file('bukti_pendaftaran');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('bukti', $filename, 'public');

        Pendaftaran::create([
            'nama_panitia' => Auth::user()->name,
            'nama_calon_siswa' => $request->nama_calon_siswa,
            'nama_orang_tua' => $request->nama_orang_tua,
            'nomor_orang_tua' => $request->nomor_orang_tua,
            'nama_rekomendasi' => $request->nama_rekomendasi,
            'bukti_pendaftaran' => $path,
            'catatan_lain' => $request->catatan_lain,
        ]);

        return redirect()->route('pendaftaran.index')->with('success', 'Data pendaftaran berhasil disimpan!');
    }

    // 4. Proses Update Data (Dari Modal Edit)
    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'nama_calon_siswa' => 'required|string|max:255',
            'nama_orang_tua' => 'required|string|max:255',
            'nomor_orang_tua' => 'required|string|max:20',
            'bukti_pendaftaran' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $data = [
            'nama_calon_siswa' => $request->nama_calon_siswa,
            'nama_orang_tua' => $request->nama_orang_tua,
            'nomor_orang_tua' => $request->nomor_orang_tua,
            'nama_rekomendasi' => $request->nama_rekomendasi,
            'catatan_lain' => $request->catatan_lain,
        ];

        // Jika panitia mengupload file bukti yang baru
        if ($request->hasFile('bukti_pendaftaran')) {
            if (Storage::disk('public')->exists($pendaftaran->bukti_pendaftaran)) {
                Storage::disk('public')->delete($pendaftaran->bukti_pendaftaran);
            }

            $file = $request->file('bukti_pendaftaran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('bukti', $filename, 'public');
            
            $data['bukti_pendaftaran'] = $path;
        }

        $pendaftaran->update($data);

        return redirect()->route('pendaftaran.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    // 5. Proses Hapus Data
    public function destroy(Pendaftaran $pendaftaran)
    {
        if (Storage::disk('public')->exists($pendaftaran->bukti_pendaftaran)) {
            Storage::disk('public')->delete($pendaftaran->bukti_pendaftaran);
        }

        $pendaftaran->delete();

        return redirect()->route('pendaftaran.index')->with('success', 'Data siswa berhasil dihapus secara permanen!');
    }

    // 6. Cetak Bukti Individu (HTML/Print Browser)
    public function cetak(Pendaftaran $pendaftaran)
    {
        return view('pendaftaran.cetak', compact('pendaftaran'));
    }

    // 7. Cetak Rekap PDF Berdasarkan Rentang Tanggal (DOMPDF)
    public function cetakPdf(Request $request)
    {
        // Validasi dua input tanggal dari modal
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;

        // Ambil data antara tanggal awal (00:00:00) hingga tanggal akhir (23:59:59)
        $pendaftarans = Pendaftaran::whereBetween('created_at', [
            $tanggalAwal . ' 00:00:00', 
            $tanggalAkhir . ' 23:59:59'
        ])->orderBy('created_at', 'asc')->get();

        // Kembalikan pesan error jika tidak ada data di rentang waktu tersebut
        if ($pendaftarans->isEmpty()) {
            return redirect()->route('pendaftaran.index')
                ->with('error', 'Tidak ada data pendaftar dari tanggal ' . $tanggalAwal . ' s/d ' . $tanggalAkhir);
        }

        // Generate PDF
        $pdf = Pdf::loadView('pendaftaran.pdf', compact('pendaftarans', 'tanggalAwal', 'tanggalAkhir'));

        // Unduh PDF
        return $pdf->download('Rekap_PPDB_' . $tanggalAwal . '_sd_' . $tanggalAkhir . '.pdf');
    }
}