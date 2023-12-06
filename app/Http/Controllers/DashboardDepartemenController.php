<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
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
                if ($departemen) {
                    $mahasiswaCount = Mahasiswa::count();
                    $dosenCount = Dosen::count();
                    $departemenCount = Departemen::count();
                    $userCount = User::count();
    
                    $mahasiswa_aktif = Mahasiswa::where('status', 'active')->count();
                    $mahasiswa_tidak_aktif = Mahasiswa::where('status', '!=', 'active')->count();
    
                    $angkatan = [];
                    $tahunSekarang = date('Y');
                    $angkatan2 = range($tahunSekarang, $tahunSekarang - 6);
                    $angkatan3 = range($tahunSekarang, $tahunSekarang - 6);
    
                    // Inisialisasi array untuk menyimpan hasil akhir
    
                    // Mengisi array $angkatan dengan rentang tahun dari tahun saat ini sampai 6 tahun ke belakang
                    for ($i = 0; $i <= 6; $i++) {
                        $angkatan[] = $tahunSekarang - $i;
                    }
                    $result = array_fill_keys($angkatan, ['lulus_count' => 0, 'tidak_lulus_count' => 0, 'pkl_lulus_count' => 0, 'pkl_tidak_lulus_count' => 0, 
                        'active' => 0,
                        'cuti' => 0,
                        'mangkir' => 0,
                        'do' => 0,
                        'lulus' => 0,
                        'undur_diri' => 0,
                        'meninggal_dunia'=> 0]);
                    
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
    
                    // untuk rekap status
                    $statusMahasiswa = Mahasiswa::whereIn('angkatan', $angkatan)
                        ->select('angkatan', 'status', DB::raw('COALESCE(COUNT(*), 0) as count'))
                        ->groupBy('angkatan', 'status')
                        ->whereIn('status', ['mangkir', 'undur_diri','active','do','meninggal_dunia','lulus','cuti'])
                        ->get()
                        ->each(function ($item, $key) use (&$result) {
                            // Mengisi array $result dengan hasil query
                            $result[$item->angkatan][$item->status] = $item->count;
                    });
    
                    // Mengubah $result menjadi koleksi Laravel
                    $result = collect($result);
                    //dd($result);
                    // dd($result);
    
                    $users = User::join('roles', 'users.role_id', '=', 'roles.id')
                        ->select('users.role_id', 'roles.name')
                        ->get();
    
                    $user = User::where('id', Auth::user()->id)
                        ->select('foto')
                        ->first();
    
                    return view('departemen.dashboard', [
                        'departemen' => $departemen,
                        'result' => $result,
                        'angkatan' => $angkatan,
                        'angkatan2' => $angkatan2,
                        'angkatan3'=>$angkatan3,
                        'mahasiswas' => $mahasiswas,
                        'mahasiswa_aktif' => $mahasiswa_aktif,
                        'mahasiswa_tidak_aktif' => $mahasiswa_tidak_aktif,
                    ]);
                }
            }
    
            // Jika kondisi tidak memenuhi atau pengguna bukan operator dengan role_id 3, kembalikan respons yang sesuai
            return redirect()
                ->route('home')
                ->with('error', 'Unauthorized access!');
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

    public function rekap(Request $request)
    {
        if (Auth::user()->role_id === 4) {
            $departemen = Departemen::leftJoin('users', 'departemen.iduser', '=', 'users.id')
                ->where('departemen.iduser', Auth::user()->id)
                ->select('departemen.nama', 'departemen.kode', 'users.username')
                ->first();

            if ($departemen) {
                $mahasiswaCount = Mahasiswa::count();
                $dosenCount = Dosen::count();
                $departemenCount = Departemen::count();
                $userCount = User::count();

                $mahasiswa_aktif = Mahasiswa::where('status', 'active')->count();
                $mahasiswa_tidak_aktif = Mahasiswa::where('status', '!=', 'active')->count();

                $angkatan = [];
                $tahunSekarang = date('Y');
                $angkatan2 = range($tahunSekarang, $tahunSekarang - 6);
                $angkatan3 = range($tahunSekarang, $tahunSekarang - 6);

                // Inisialisasi array untuk menyimpan hasil akhir

                // Mengisi array $angkatan dengan rentang tahun dari tahun saat ini sampai 6 tahun ke belakang
                for ($i = 0; $i <= 6; $i++) {
                    $angkatan[] = $tahunSekarang - $i;
                }
                $result = array_fill_keys($angkatan, ['lulus_count' => 0, 'tidak_lulus_count' => 0, 'pkl_lulus_count' => 0, 'pkl_tidak_lulus_count' => 0, 
                'active' => 0,
                'cuti' => 0,
                'mangkir' => 0,
                'do' => 0,
                'lulus' => 0,
                'undur_diri' => 0,
                'meninggal_dunia'=> 0]);
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



                // untuk rekap status
                $statusMahasiswa = Mahasiswa::whereIn('angkatan', $angkatan)
                    ->select('angkatan', 'status', DB::raw('COALESCE(COUNT(*), 0) as count'))
                    ->groupBy('angkatan', 'status')
                    ->get()
                    ->each(function ($item, $key) use (&$result) {
                        // Mengisi array $result dengan hasil query
                        $result[$item->angkatan][$item->status] = $item->count;
                });

                // Mengubah $result menjadi koleksi Laravel
                $result = collect($result);

                $users = User::join('roles', 'users.role_id', '=', 'roles.id')
                    ->select('users.role_id', 'roles.name')
                    ->get();

                $user = User::where('id', Auth::user()->id)
                    ->select('foto')
                    ->first();

                return view('departemen.rekap', [
                    'departemen' => $departemen,
                    'result' => $result,
                    'angkatan' => $angkatan,
                    'angkatan2' => $angkatan2,
                    'angkatan3'=>$angkatan3,
                    'mahasiswas' => $mahasiswas,
                    'mahasiswa_aktif' => $mahasiswa_aktif,
                    'mahasiswa_tidak_aktif' => $mahasiswa_tidak_aktif,
                ]);
            }
        }
    }
}
