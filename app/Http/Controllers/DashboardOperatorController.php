<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\GenerateAkun;
use App\Models\Departemen;
use App\Models\Operator;
use App\Models\User;
use App\Models\IRS;
use App\Models\KHS;
use App\Models\PKL;
use App\Models\Skripsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DashboardOperatorController extends Controller
{
    public function dashboardOperator(Request $request)
    {
        if (Auth::check() && Auth::user()->role_id === 3) {
            $operators = Operator::leftJoin('users', 'operator.iduser', '=', 'users.id')
                ->where('operator.iduser', Auth::user()->id)
                ->select('operator.nama', 'operator.nip', 'users.username')
                ->first();

            if ($operators) {
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
                $result = array_fill_keys($angkatan, ['lulus_count' => 0, 'tidak_lulus_count' => 0,]); 
                $result1 = array_fill_keys($angkatan, ['pkl_lulus_count' => 0, 'pkl_tidak_lulus_count' => 0,]);
                $result2 = array_fill_keys($angkatan, [
                'active' => 0,
                'cuti' => 0,
                'mangkir' => 0,
                'do' => 0,
                'lulus' => 0,
                'undur diri' => 0,
                'meninggal'=> 0]);
                //dd($angkatan);
                $mahasiswas = DB::table('mahasiswa as m')
                    ->leftJoin('pkl as p', 'm.nim', '=', 'p.nim')
                    ->whereIn('m.angkatan', $angkatan)
                    ->select('m.angkatan', DB::raw('COALESCE(SUM(CASE WHEN p.status = "verified" THEN 1 ELSE 0 END), 0) as pkl_lulus_count'), DB::raw('COALESCE(SUM(CASE WHEN p.nim IS NULL OR p.status != "verified" THEN 1 ELSE 0 END), 0) as pkl_tidak_lulus_count'))
                    ->groupBy('m.angkatan')
                    ->get()
                    ->each(function ($item, $key) use (&$result1) {
                        // Mengisi array $result dengan hasil query
                        $result1[$item->angkatan]['pkl_lulus_count'] = $item->pkl_lulus_count;
                        $result1[$item->angkatan]['pkl_tidak_lulus_count'] = $item->pkl_tidak_lulus_count;
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
                    ->whereIn('status', ['mangkir', 'undur diri','active','do','meninggal','lulus','cuti'])
                    ->get()
                    ->each(function ($item, $key) use (&$result2) {
                        // Mengisi array $result dengan hasil query
                        $result2[$item->angkatan][$item->status] = $item->count;
                });
                // Mengubah $result menjadi koleksi Laravel
                $result = collect($result);
                $result1 = collect($result1);
                $result2 = collect($result2);
                //dd($result);
                //dd($result);

                $users = User::join('roles', 'users.role_id', '=', 'roles.id')
                    ->select('users.role_id', 'roles.name')
                    ->get();

                $user = User::where('id', Auth::user()->id)
                    ->select('foto')
                    ->first();

                return view('operator.dashboard', [
                    'operators' => $operators,
                    'result' => $result,
                    'result1' => $result1,
                    'result2' => $result2,
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

    public function mahasiswa()
    {
        $mahasiswas = Mahasiswa::join('users', 'mahasiswa.iduser', '=', 'users.id')
            ->join('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
            ->join('generate_akun', 'generate_akun.nim', '=', 'mahasiswa.nim')
            ->select('mahasiswa.nama', 'mahasiswa.nim as nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'mahasiswa.username', 'generate_akun.password', 'dosen_wali.nip', 'dosen_wali.nama as dosen_nama', 'mahasiswa.jalur_masuk', 'users.foto')
            ->get();

        // Ambil nim dari salah satu mahasiswa
        $nim = $mahasiswas->first()->nim;

        $nim_mahasiswa = Mahasiswa::where('nim', $nim)->select('nama','nim')->first();   
        $dosens = Dosen::all();

        return view('operator.mahasiswa', ['mahasiswas' => $mahasiswas, 'dosens' => $dosens, 'nim_mahasiswa' => $nim_mahasiswa]);
    }


    public function deleteMahasiswa($nim_mahasiswa)
    {
        $mahasiswa = Mahasiswa::where('nim', $nim_mahasiswa)->first();

        if ($mahasiswa) {
            // Dapatkan iduser dari mahasiswa

            // Hapus data terkait
            IRS::where('nim', $nim_mahasiswa)->delete();
            KHS::where('nim', $nim_mahasiswa)->delete();
            PKL::where('nim', $nim_mahasiswa)->delete();
            Skripsi::where('nim', $nim_mahasiswa)->delete();
            GenerateAkun::where('nim',$nim_mahasiswa)->delete();

            // Hapus mahasiswa
            $mahasiswa->delete();

            return redirect()->route('mahasiswa')->with('success', 'Mahasiswa dan semua data terkait berhasil dihapus.');
        }
        else {
            return redirect()->route('mahasiswa')->with('error', 'Tidak dapat menghapus mahasiswa.');
        }
    }




    public function store(Request $request)
    {
        //dd($request);
        $validated = $request->validate([
            'namamhs' => 'required|regex:/^[a-zA-Z\s]+$/u',
            'nimmhs' => ['required', 'string', 'regex:/^\d{1,20}$/'],
            'angkatanmhs' => 'required|integer',
            'nipdsn' => 'required|exists:dosen_wali,nip',
            'jalur_masukmhs' => [
                'required',
                'regex:/^(SNMPTN|SBMPTN|MANDIRI)$/', // Jalur masuk harus di antara tiga pilihan ini
                'uppercase', // Tulisan harus kapital
            ],
        ]);
        //dd($validated);
        $username = strtolower(str_replace(' ', '', $request->input('namamhs')));
        // Cek apakah username sudah digunakan, jika ya, tambahkan angka acak
        if (User::where('username', $username)->exists()) {
            $username = strtolower(str_replace(' ', '', $request->input('namamhs'))) . rand(1, 100);
        }

        $password = Str::random(8);

        DB::transaction(function () use ($request, $username, $password, $validated) {
            // Membuat user baru
            $user = new User();
            $user->username = $username;
            $user->password = $password;
            $user->role_id = 1;

            $user->save();
            // Membuat mahasiswa baru
            $mahasiswa = new Mahasiswa();
            $mahasiswa->nama = $validated['namamhs'];
            $mahasiswa->nim = $validated['nimmhs'];
            $mahasiswa->angkatan = $validated['angkatanmhs'];
            $mahasiswa->status = 'active';
            $mahasiswa->nip = $validated['nipdsn'];
            $mahasiswa->username = $username;
            $mahasiswa->iduser = $user->id;
            $mahasiswa->jalur_masuk = $validated['jalur_masukmhs'];
            $mahasiswa->save();

            $generate_akun = new GenerateAkun();
            $generate_akun->nim = $validated['nimmhs'];
            $generate_akun->username = $username;
            $generate_akun->password = $password;
            $generate_akun->save();
        });

        $mahasiswas = Mahasiswa::join('users', 'mahasiswa.iduser', '=', 'users.id')
            ->join('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
            ->join('generate_akun', 'generate_akun.nim', '=', 'mahasiswa.nim')
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'users.username', 'generate_akun.password', 'dosen_wali.nip', 'dosen_wali.nama as dosen_nama', 'mahasiswa.jalur_masuk', 'users.foto')
            ->get();
        $dosens = Dosen::all();
        return view('operator.mahasiswa', ['mahasiswas' => $mahasiswas, 'dosens' => $dosens, 'success' => 'Data Mahasiswa berhasil ditambahkan.']);
    }

    public function searchOperator(Request $request)
    {
        $search = $request->input('search');

        $mahasiswas = Mahasiswa::join('users', 'mahasiswa.iduser', '=', 'users.id')
            ->join('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
            ->join('generate_akun', 'generate_akun.nim', '=', 'mahasiswa.nim')
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'users.username', 'generate_akun.password', 'dosen_wali.nip', 'dosen_wali.nama as dosen_nama', 'mahasiswa.jalur_masuk', 'users.foto')
            ->where(function ($query) use ($search) {
                $query
                    ->where('mahasiswa.nama', 'like', '%' . $search . '%')
                    ->orWhere('mahasiswa.nim', 'like', '%' . $search . '%')
                    ->orWhere('mahasiswa.angkatan', 'like', '%' . $search . '%')
                    ->orWhere('mahasiswa.jalur_masuk', 'like', '%' . $search . '%')
                    ->orWhere('mahasiswa.status', 'like', '%' . $search . '%');
            })
            ->get();

        $dosens = Dosen::all();

        return view('operator.mahasiswa', ['mahasiswas' => $mahasiswas, 'dosens' => $dosens, 'search' => $search]);
    }

    public function rekap(Request $request)
    {
        if (Auth::check() && Auth::user()->role_id === 3) {
            $operators = Operator::leftJoin('users', 'operator.iduser', '=', 'users.id')
                ->where('operator.iduser', Auth::user()->id)
                ->select('operator.nama', 'operator.nip', 'users.username')
                ->first();

            if ($operators) {
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
                'undur diri' => 0,
                'meninggal'=> 0]);
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

                return view('operator.rekap', [
                    'operators' => $operators,
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

    public function downloadRekapPKL(Request $request){
        $angkatan = [];
        $tahunSekarang = date('Y');
        for ($i = 0; $i <= 6; $i++) {
            $angkatan[] = $tahunSekarang - $i;
        }
        $result = array_fill_keys($angkatan, ['pkl_lulus_count' => 0, 'pkl_tidak_lulus_count' => 0]);
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
        $pdf ->loadView('operator.downloadRekapPKL',['mahasiswas'=>$mahasiswas, 'angkatan'=>$angkatan,'result'=>$result]);
        return $pdf->stream('rekap-pkl.pdf');
    }

    public function downloadRekapSkripsi(Request $request){
        $angkatan = [];
        $tahunSekarang = date('Y');
        for ($i = 0; $i <= 6; $i++) {
            $angkatan[] = $tahunSekarang - $i;
        }
        $result = array_fill_keys($angkatan, ['lulus_count' => 0, 'tidak_lulus_count' => 0]);
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
        $result = collect($result);

        $pdf = app('dompdf.wrapper');
        $pdf ->loadView('operator.downloadRekapSkripsi',['mahasiswasSkripsi'=>$mahasiswasSkripsi, 'angkatan'=>$angkatan,'result'=>$result]);
        return $pdf->stream('rekap-skripsi.pdf');
    }

    public function downloadRekapStatus(Request $request){
        $angkatan = [];
        $tahunSekarang = date('Y');
        for ($i = 0; $i <= 6; $i++) {
            $angkatan[] = $tahunSekarang - $i;
        }
        $result = array_fill_keys($angkatan, ['lulus_count' => 0, 'tidak_lulus_count' => 0, 'pkl_lulus_count' => 0, 'pkl_tidak_lulus_count' => 0, 
                'active' => 0,
                'cuti' => 0,
                'mangkir' => 0,
                'do' => 0,
                'lulus' => 0,
                'undur diri' => 0,
                'meninggal'=> 0]);
        $statusMahasiswa = Mahasiswa::whereIn('angkatan', $angkatan)
                ->select('angkatan', 'status', DB::raw('COALESCE(COUNT(*), 0) as count'))
                ->groupBy('angkatan', 'status')
                ->get()
                ->each(function ($item, $key) use (&$result) {
                    // Mengisi array $result dengan hasil query
                    $result[$item->angkatan][$item->status] = $item->count;
                });
        $result = collect($result);

        $pdf = app('dompdf.wrapper');
        $pdf ->loadView('operator.downloadRekapStatus',['angkatan'=>$angkatan,'result'=>$result]);
        return $pdf->stream('rekap-status.pdf');
    }
    
}
