<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DashboardDepartemenController extends Controller
{
    public function dashboardDepartemen(Request $request)
    {
        if (Auth::user()->role_id === 4) {
            $departemen = Departemen::leftJoin('users', 'departemen.iduser', '=', 'users.id')
                ->where('departemen.iduser', Auth::user()->id)
                ->select('departemen.nama', 'departemen.kode', 'users.username')
                ->first();
            $angkatan = [];
            $tahunSekarang = date('Y');
            $angkatan2 = range($tahunSekarang, $tahunSekarang - 6);

            // Inisialisasi array untuk menyimpan hasil akhir

            // Mengisi array $angkatan dengan rentang tahun dari tahun saat ini sampai 6 tahun ke belakang
            for ($i = 0; $i <= 6; $i++) {
                $angkatan[] = $tahunSekarang - $i;
            }
            $result = array_fill_keys($angkatan, ['lulus_count' => 0, 'tidak_lulus_count' => 0, 'pkl_lulus_count' => 0, 'pkl_tidak_lulus_count' => 0]);
            //dd($angkatan);
            $mahasiswas = DB::table('mahasiswa as m')
                ->leftJoin('pkl as p', 'm.nim', '=', 'p.nim')
                ->whereIn('m.angkatan', $angkatan)
                ->select('m.angkatan', DB::raw('COALESCE(SUM(CASE WHEN p.status = "verified" THEN 1 ELSE 0 END), 0) as pkl_lulus_count'), DB::raw('COALESCE(SUM(CASE WHEN p.nim IS NULL OR p.status != "verified" THEN 1 ELSE 0 END), 0) as pkl_tidak_lulus_count'))
                ->groupBy('m.angkatan')
                ->get()
                ->each(function ($item, $key) use (&$result) {
                    // Mengisi array $result dengan hasil query
                    $result[$item->angkatan]['pkl_lulus_count'] = $item->pkl_lulus_count;
                    $result[$item->angkatan]['pkl_tidak_lulus_count'] = $item->pkl_tidak_lulus_count;
                });

            //untuk rekap skripsi

            $mahasiswasSkripsi = DB::table('mahasiswa as m')
                ->leftJoin('skripsi as s', 'm.nim', '=', 's.nim')
                ->whereIn('m.angkatan', $angkatan)
                ->select('m.angkatan', DB::raw('COALESCE(SUM(CASE WHEN s.status = "verified" THEN 1 ELSE 0 END), 0) as lulus_count'), DB::raw('COALESCE(SUM(CASE WHEN s.nim IS NULL OR s.status != "verified" THEN 1 ELSE 0 END), 0) as tidak_lulus_count'))
                ->groupBy('m.angkatan')
                ->get()
                ->each(function ($item, $key) use (&$result) {
                    // Mengisi array $result dengan hasil query
                    $result[$item->angkatan]['lulus_count'] = $item->lulus_count;
                    $result[$item->angkatan]['tidak_lulus_count'] = $item->tidak_lulus_count;
                });

            // Mengubah $result menjadi koleksi Laravel
            $result = collect($result);

            //dd($result);

            $mahasiswa_aktif = Mahasiswa::where('status', 'active')->count();
            $mahasiswa_tidak_aktif = Mahasiswa::where('status', '!=', 'active')->count();

            // $user = User::where('id', Auth::user()->id)->select('foto')->first();
            if ($departemen) {
                return view('departemen.dashboard', [
                    'departemen' => $departemen,
                    'mahasiswas' => $mahasiswas,
                    'mahasiswasSkripsi' => $mahasiswasSkripsi,
                    'angkatan' => $angkatan,
                    'result' => $result,
                    'angkatan2' => $angkatan2,
                    'mahasiswa_aktif' => $mahasiswa_aktif, // Update variable name
                    'mahasiswa_tidak_aktif' => $mahasiswa_tidak_aktif, // Update variable name
                ]);
            }
        }
        return view('departemen.dashboard');
    }

    public function PreviewPKL()
    {
        $angkatan = [];
        $tahunSekarang = date('Y');
        // Inisialisasi array untuk menyimpan hasil akhir

        // Mengisi array $angkatan dengan rentang tahun dari tahun saat ini sampai 6 tahun ke belakang
        for ($i = 0; $i <= 6; $i++) {
            $angkatan[] = $tahunSekarang - $i;
        }

        $result = array_fill_keys($angkatan, ['pkl_lulus_count' => 0, 'pkl_tidak_lulus_count' => 0]);
        //dd($angkatan);
        $mahasiswas = DB::table('mahasiswa as m')
            ->leftJoin('pkl as p', 'm.nim', '=', 'p.nim')
            ->whereIn('m.angkatan', $angkatan)
            ->select('m.angkatan', DB::raw('COALESCE(SUM(CASE WHEN p.status = "verified" THEN 1 ELSE 0 END), 0) as pkl_lulus_count'), DB::raw('COALESCE(SUM(CASE WHEN p.nim IS NULL OR p.status != "verified" THEN 1 ELSE 0 END), 0) as pkl_tidak_lulus_count'))
            ->groupBy('m.angkatan')
            ->get()
            ->each(function ($item, $key) use (&$result) {
                // Mengisi array $result dengan hasil query
                $result[$item->angkatan]['pkl_lulus_count'] = $item->pkl_lulus_count;
                $result[$item->angkatan]['pkl_tidak_lulus_count'] = $item->pkl_tidak_lulus_count;
            });
        $result = collect($result);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('departemen.DownloadRekapPKLDepartemen', ['mahasiswas' => $mahasiswas, 'angkatan' => $angkatan, 'result' => $result]);
        return $pdf->stream('rekap-pkl.pdf');
    }

    public function PreviewSkripsi()
    {
        $angkatan = [];

        $tahunSekarang = date('Y');
        // Inisialisasi array untuk menyimpan hasil akhir

        // Mengisi array $angkatan dengan rentang tahun dari tahun saat ini sampai 6 tahun ke belakang
        for ($i = 0; $i <= 6; $i++) {
            $angkatan[] = $tahunSekarang - $i;
        }
        $result = array_fill_keys($angkatan, ['lulus_count' => 0, 'tidak_lulus_count' => 0]);
        //dd($angkatan);
        //untuk rekap skripsi

        $mahasiswasSkripsi = DB::table('mahasiswa as m')
                    ->leftJodin('skripsi as s', 'm.nim', '=', 's.nim')
                    ->whereIn('m.angkatan', $angkatan)
                    ->select('m.angkatan', DB::raw('COALESCE(SUM(CASE WHEN s.status = "verified" THEN 1 ELSE 0 END), 0) as lulus_count'), DB::raw('COALESCE(SUM(CASE WHEN s.nim IS NULL OR s.status != "verified" THEN 1 ELSE 0 END), 0) as tidak_lulus_count'))
                    ->groupBy('m.angkatan')
                    ->get()
                    ->each(function ($item, $key) use (&$result) {
                        // Mengisi array $result dengan hasil query
                        $result[$item->angkatan]['lulus_count'] = $item->lulus_count;
                        $result[$item->angkatan]['tidak_lulus_count'] = $item->tidak_lulus_count;
                    });

        // Mengubah $result menjadi koleksi Laravel
        $result = collect($result);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('departemen.DownloadRekapSkripsiDepartemen', ['mahasiswasSkripsi' => $mahasiswasSkripsi, 'angkatan' => $angkatan, 'result' => $result]);
        return $pdf->stream('rekap-skripsi.pdf');
    }
}
