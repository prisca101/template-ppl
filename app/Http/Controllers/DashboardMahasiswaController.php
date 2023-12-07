<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Skripsi;
use App\Models\KHS;
use App\Models\PKL;
use App\Models\IRS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardMahasiswaController extends Controller
{
    public function dashboardMahasiswa(Request $request)
    {
        // Pastikan bahwa yang sedang login memiliki role_id 1 (mahasiswa)
        if (Auth::user()->role_id === 1) {
            // Ambil data mahasiswa yang sedang login
            $mahasiswa = Mahasiswa::leftJoin('users', 'mahasiswa.iduser', '=', 'users.id')
                ->leftJoin('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
                ->where('mahasiswa.iduser', Auth::user()->id)
                ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'users.username', 'dosen_wali.nama as dosen_nama','mahasiswa.jalur_masuk')
                ->first();

            $nim = $request->user()->mahasiswa->nim;
            $user = User::where('id', Auth::user()->id)->select('foto')->first();

            $latestPKL = PKL::where('nim',$nim)
                        ->where('status','verified')
                        ->orderBy('created_at', 'desc')->first();
            $nilaiPKL = $latestPKL ? $latestPKL->nilai : null;
            $statusPKL = $latestPKL ? $latestPKL->statusPKL : null;
            $status = $latestPKL ? $latestPKL->status : null;

            $latestSkripsi = Skripsi::where('nim',$nim)
                        ->where('status','verified')
                        ->orderBy('created_at', 'desc')->first();
            $nilaiSkripsi = $latestSkripsi ? $latestSkripsi->nilai : null;
            $statusSkripsi = $latestSkripsi ? $latestSkripsi->statusSkripsi : null;
            $statusSkr = $latestSkripsi ? $latestSkripsi->status : null;

            $latestKHS = KHS::where('nim',$nim)
                            ->where('status','verified')
                            ->orderBy('created_at', 'desc')->first();
            $SKSKumulatif = $latestKHS ? $latestKHS->jumlah_sks_kumulatif : null;
            $IPKumulatif = $latestKHS ? $latestKHS->ip_kumulatif : null;
            $statusKHS = $latestKHS ? $latestKHS->status : null;

            $latestIRS = IRS::where('nim',$nim)
                            ->where('status','verified')
                            ->orderBy('created_at', 'desc')->first();
            $SemesterAktif = $latestIRS ? $latestIRS->semester_aktif : null;
            $JumlahSKS = $latestIRS ? $latestIRS->jumlah_sks : null;
            $statusIRS = $latestIRS ? $latestIRS->status : null;
            $irsData = IRS::join('mahasiswa','mahasiswa.nim','=','irs.nim')
                ->where('irs.nim', $nim)
                ->select('mahasiswa.status as mhsstatus','irs.status as status', 'irs.semester_aktif','irs.jumlah_sks','irs.scanIRS')
                ->get()
                ->keyBy('semester_aktif'); // Gunakan semester_aktif sebagai kunci array

            $khsData = KHS::join('mahasiswa','mahasiswa.nim','=','khs.nim')
                ->where('khs.nim', $nim)
                ->select('mahasiswa.status as mhsstatus','khs.status as status', 'khs.semester_aktif','khs.jumlah_sks','khs.jumlah_sks_kumulatif','khs.ip_semester','khs.ip_kumulatif')
                ->get()
                ->keyBy('semester_aktif');

            $pklData = PKL::join('mahasiswa','mahasiswa.nim','=','pkl.nim')
                ->where('pkl.nim', $nim)
                ->select('mahasiswa.status as mhsstatus','pkl.status as status', 'pkl.semester_aktif', 'pkl.nilai','pkl.scanPKL')
                ->get()
                ->keyBy('semester_aktif');
        
            $skripsiData = Skripsi::join('mahasiswa','mahasiswa.nim','=','skripsi.nim')
                ->where('skripsi.nim', $nim)
                ->select('mahasiswa.status as mhsstatus','skripsi.status as status', 'skripsi.semester_aktif', 'skripsi.nilai','skripsi.scanSkripsi','skripsi.lama_studi','skripsi.tanggal_sidang')
                ->get()
                ->keyBy('semester_aktif');

            $lastVerifiedPKL = PKL::join('mahasiswa','mahasiswa.nim','=','pkl.nim')
                ->where('pkl.nim', $nim)
                ->where('pkl.status', 'verified')
                ->select('mahasiswa.status as mhsstatus','pkl.status as status', 'pkl.semester_aktif', 'pkl.nilai','pkl.scanPKL')
                ->orderBy('semester_aktif')
                ->first();
            if ($mahasiswa) {
                return view('mahasiswa.dashboard', ['irsData'=>$irsData,'khsData'=>$khsData, 'pklData'=>$pklData,'skripsiData'=>$skripsiData,'lastVerifiedPKL'=>$lastVerifiedPKL,
                'statusIRS'=>$statusIRS,'JumlahSKS'=>$JumlahSKS,'SemesterAktif'=>$SemesterAktif,'statusKHS'=>$statusKHS,
                'mahasiswa' => $mahasiswa, 'user' => $user,'status'=>$status,'statusSkr'=>$statusSkr, 
                'statusPKL' => $statusPKL,'statusSkripsi'=>$statusSkripsi,'SKSKumulatif'=>$SKSKumulatif,'IPKumulatif'=>$IPKumulatif,'nilaiPKL'=>$nilaiPKL,'nilaiSkripsi'=>$nilaiSkripsi]);
            }
        }

        // Jika user tidak memiliki role_id 1 atau tidak ditemukan data mahasiswa yang sesuai, Anda dapat mengirimkan tampilan yang sesuai.
        return view('mahasiswa.dashboard'); // Misalnya, tampilan kosong.
    }
}
