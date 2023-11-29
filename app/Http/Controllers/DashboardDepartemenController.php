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
    
            // Mengisi array $angkatan dengan rentang tahun dari tahun saat ini sampai 6 tahun ke belakang
            for ($i = 0; $i <= 6; $i++) {
                $angkatan[] = $tahunSekarang - $i;
            }

            $mahasiswas = DB::table('mahasiswa as m')
                ->leftJoin('pkl as p', 'm.nim', '=', 'p.nim')
                ->select('m.angkatan',
                    DB::raw('COALESCE(SUM(CASE WHEN p.status = "verified" THEN 1 ELSE 0 END), 0) as lulus_count'), 
                    DB::raw('COALESCE(SUM(CASE WHEN p.nim IS NULL OR p.status != "verified" THEN 1 ELSE 0 END), 0) as tidak_lulus_count'))
                ->groupBy('m.angkatan')
                ->get();
        
            // Tambahkan penanganan jika $mahasiswas kosong
            if ($mahasiswas->isEmpty()) {
                // Atau tindakan yang sesuai dengan kebutuhan Anda, misalnya, 
                // memberikan nilai default atau pesan yang sesuai.
                return view('RekapPKLDepartemen', ['mahasiswas' => null]);
            }

            //untuk rekap skripsi

            $mahasiswasSkripsi = DB::table('mahasiswa as m')
                ->leftJoin('skripsi as s', 'm.nim', '=', 's.nim')
                ->select('m.angkatan', DB::raw('COALESCE(SUM(CASE WHEN s.status = "verified" THEN 1 ELSE 0 END), 0) as lulus_count'), 
                                        DB::raw('COALESCE(SUM(CASE WHEN s.nim IS NULL OR s.status != "verified" THEN 1 ELSE 0 END), 0) as tidak_lulus_count'))
                ->groupBy('m.angkatan')
                ->get();

            // $user = User::where('id', Auth::user()->id)->select('foto')->first();
            if ($departemen) {
                return view('departemen.dashboard', ['departemen' => $departemen, 'mahasiswas' => $mahasiswas, 'mahasiswasSkripsi' => $mahasiswasSkripsi, 'angkatan'=>$angkatan]);
            }
        }
        return view('departemen.dashboard');
    }
}