<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\GenerateAkun;
use App\Models\Departemen;
use App\Models\Operator;
use App\Models\User;
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
                'undur_diri' => 0,]);
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

                // dd($result);

                $users = User::join('roles', 'users.role_id', '=', 'roles.id')
                    ->select('users.role_id', 'roles.name')
                    ->get();

                $user = User::where('id', Auth::user()->id)
                    ->select('foto')
                    ->first();

                return view('operator.dashboard', [
                    'operators' => $operators,
                    'result' => $result,
                    'angkatan' => $angkatan,
                    'angkatan2' => $angkatan2,
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
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'users.username', 'generate_akun.password', 'dosen_wali.nip', 'dosen_wali.nama as dosen_nama', 'mahasiswa.jalur_masuk', 'users.foto')
            ->get();
        $dosens = Dosen::all();
        return view('operator.mahasiswa', ['mahasiswas' => $mahasiswas, 'dosens' => $dosens]);
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
}
