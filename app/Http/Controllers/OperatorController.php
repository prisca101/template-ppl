<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use App\Models\Dosen;
use App\Models\IRS;
use App\Models\KHS;
use App\Models\PKL;
use App\Models\Skripsi;
use App\Models\GenerateAkun;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Imports\MahasiswaImport;
use App\Exports\MahasiswaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class OperatorController extends Controller
{
    public function index()
    {
        $mahasiswas = Mahasiswa::join('users', 'mahasiswa.username', '=', 'users.username')
            ->join('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'users.username', 'users.password', 'dosen_wali.nip', 'dosen_wali.nama as dosen_nama', 'mahasiswa.jalur_masuk')
            ->get();

        $users = User::join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.role_id', 'roles.name')
            ->get();

        $operators = Operator::join('users', 'operator.username', '=', 'users.username')
            ->select('users.username', 'users.password', 'operator.nama', 'operator.nip', 'operator.fotoProfil')
            ->get();

        return view('dashboardOperator', ['operators' => $operators, 'mahasiswas' => $mahasiswas, 'users' => $users]);
    }

    public function edit(Request $request)
    {
        $user = $request->user();
        $nip = $request->user()->operator->nip;
        $operators = Operator::join('users', 'operator.iduser', '=', 'users.id')
            ->where('nip', $nip)
            ->select('operator.nama', 'operator.nip', 'users.id', 'users.username', 'users.foto')
            ->first();
        return view('operator.profil', ['user' => $user, 'operators' => $operators]);
    }

    public function showEdit(Request $request)
    {
        $user = $request->user();
        $nip = $request->user()->operator->nip;
        $operators = Operator::join('users', 'operator.iduser', '=', 'users.id')
            ->where('nip', $nip)
            ->select('operator.nama', 'operator.nip', 'users.id', 'users.username', 'users.password', 'users.foto')
            ->first();
        return view('operator.profil-edit', ['user' => $user, 'operators' => $operators]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'username' => 'nullable|string',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8',
            'new_confirm_password' => 'nullable|same:new_password',
            'foto' => 'max:10240|image|mimes:jpeg,png,jpg',
        ]);

        if ($request->has('foto')) {
            $fotoPath = $request->file('foto')->store('profile', 'public');
            $validated['foto'] = $fotoPath;

            $user->update([
                'foto' => $validated['foto'],
            ]);
        }

        // Check if 'new_password' key exists and not null in $validated
        if (array_key_exists('new_password', $validated) && $validated['new_password'] !== null) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return redirect()
                    ->route('operator.showEdit3')
                    ->with('error', 'Password lama tidak cocok');
            }
        }

        DB::beginTransaction();

        try {
            $userData = ['username' => $validated['username'] ?? null];

            if (!is_null($userData['username'])) {
                $user->update($userData);
                Operator::where('iduser', $user->id)->update($userData);
            }

            if (array_key_exists('new_password', $validated) && $validated['new_password'] !== null) {
                $user->update([
                    'password' => Hash::make($validated['new_password']),
                ]);
            }

            DB::commit();

            return redirect()
                ->route('edit3')
                ->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('showEdit3')
                ->with('error', 'Gagal memperbarui profil.');
        }
    }

    public function tambah()
    {
        $mahasiswas = Mahasiswa::join('dosen_wali', 'dosen_wali.nip', '=', 'mahasiswa.nip')
            ->select('mahasiswa.nama as nama', 'mahasiswa.nim', 'mahasiswa.nip', 'mahasiswa.angkatan', 'dosen_wali.nama as dosen_nama', 'mahasiswa.username', 'mahasiswa.jalur_masuk')
            ->whereNull('mahasiswa.iduser')
            ->get();

        return view('operator.importMahasiswa', compact('mahasiswas'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        $data = Excel::toArray(new MahasiswaImport(), $request->file('file'));

        foreach ($data[0] as $row) {
            $validator = Validator::make($row, [
                'nama' => 'required|regex:/^[a-zA-Z\s]*$/',
                'nim' => 'required|numeric|digits_between:1,20',
                'angkatan' => 'required|integer',
                'jalur_masuk' => 'required|in:SNMPTN,SBMPTN,MANDIRI',
                'nip' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                // Handle validation failure
                // For example, you can redirect back with errors
                return redirect()
                    ->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        session(['mahasiswa_data' => $data[0]]);
        return redirect()->route('mahasiswa.preview');
    }

    public function preview()
    {
        $data = session('mahasiswa_data');
        return view('operator.importMahasiswa', ['data' => $data]);
    }

    public function generateAkun()
    {
        $data = session('mahasiswa_data');

        foreach ($data as $row) {
            if (Mahasiswa::where('nim', $row['nim'])->exists()) {
                return redirect()
                    ->route('mahasiswa.preview')
                    ->with('error', 'NIM / Mahasiswa sudah terdaftar');
            }

            $username = strtolower(str_replace(' ', '', $row['nama']));

            while (User::where('username', $username)->exists()) {
                $username = strtolower(str_replace(' ', '', $row['nama'])) . rand(1, 100);
            }

            $password = Str::random(8);

            $user = User::create([
                'username' => $username,
                'password' => Hash::make($password), // Hash the password
                'role_id' => 1,
            ]);

            $row['iduser'] = $user->id;
            $row['username'] = $username;
            $row['status'] = 'active';

            Mahasiswa::create($row);

            GenerateAkun::create([
                'nim' => $row['nim'],
                'username' => $username,
                'password' => $password, // Password belum di-hash
            ]);
        }
        return redirect()
            ->route('mahasiswa')
            ->with('success', 'Data Mahasiswa berhasil ditambahkan');
    }

    public function export()
    {
        $mahasiswas = Mahasiswa::join('users', 'mahasiswa.iduser', '=', 'users.id')
            ->join('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
            ->join('generate_akun', 'generate_akun.nim', '=', 'mahasiswa.nim')
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'users.username', 'generate_akun.password', 'dosen_wali.nip as nip', 'dosen_wali.nama as dosen_nama', 'mahasiswa.jalur_masuk', 'users.foto')
            ->get();
        $dosens = Dosen::all();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('operator.downloadMahasiswa', ['mahasiswas' => $mahasiswas, 'dosens' => $dosens]);
        return $pdf->stream('daftar-list-mahasiswa.pdf');
    }

    public function daftarstatus($angkatan, $status)
    {
        $operator = Operator::leftJoin('users', 'operator.iduser', '=', 'users.id')
            ->where('operator.iduser', Auth::user()->id)
            ->select('operator.nama', 'operator.nip', 'users.username')
            ->first();
        $daftar = Mahasiswa::join('dosen_wali', 'dosen_wali.nip', '=', 'mahasiswa.nip')
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'dosen_wali.nama as dosen_nama')
            ->where('mahasiswa.angkatan', $angkatan)
            ->where('mahasiswa.status', $status)
            ->get();

        $namastatus = [
            'active' => 'Aktif',
            'lulus' => 'Lulus',
            'meninggal_dunia' => 'Meninggal Dunia',
            'do' => 'Drop Out',
            'cuti' => 'Cuti',
            'undur_diri' => 'Undur Diri',
            'mangkir' => 'Mangkir',
        ];

        $status_label = isset($namastatus[$status]) ? $namastatus[$status] : $status;

        return view('operator.daftarstatus', ['daftar' => $daftar, 'operator' => $operator, 'namastatus' => $status_label, 'angkatan' => $angkatan, 'status' => $status]);
    }

    public function pkllulus($angkatan, $status)
    {
        $operator = Operator::leftJoin('users', 'operator.iduser', '=', 'users.id')
            ->where('operator.iduser', Auth::user()->id)
            ->select('operator.nama', 'operator.nip', 'users.username')
            ->first();
        $mahasiswas = Mahasiswa::leftJoin('pkl', function ($join) use ($status) {
            $join->on('mahasiswa.nim', '=', 'pkl.nim')->where('pkl.status', '=', 'verified');
        })
            ->join('dosen_wali', 'dosen_wali.nip', '=', 'mahasiswa.nip')
            ->where('mahasiswa.angkatan', $angkatan)
            ->where(function ($query) use ($status) {
                $query->where('pkl.status', $status);
            })
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'pkl.nilai', 'pkl.statusPKL', 'pkl.status', 'pkl.scanPKL', 'dosen_wali.nama as dosen_nama')
            ->get();
        return view('operator.pkllulus', ['mahasiswas' => $mahasiswas, 'operator' => $operator, 'angkatan' => $angkatan, 'status' => $status]);
    }

    public function pkltidaklulus($angkatan, $status)
    {
        $operator = Operator::leftJoin('users', 'operator.iduser', '=', 'users.id')
            ->where('operator.iduser', Auth::user()->id)
            ->select('operator.nama', 'operator.nip', 'users.username')
            ->first();
        $mahasiswas = Mahasiswa::leftJoin('pkl', function ($join) use ($status) {
            $join->on('mahasiswa.nim', '=', 'pkl.nim')->where('pkl.status', '=', 'verified');
        })
            ->join('dosen_wali', 'dosen_wali.nip', '=', 'mahasiswa.nip')
            ->where('mahasiswa.angkatan', $angkatan)
            ->where(function ($query) use ($status) {
                $query->whereNull('pkl.nim')->orWhere(function ($query) use ($status) {
                    $query->where('pkl.status', '=', $status);
                });
            })
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'pkl.nilai', 'pkl.status', 'pkl.scanPKL', 'dosen_wali.nama as dosen_nama')
            ->get();
        return view('operator.pkltidaklulus', ['mahasiswas' => $mahasiswas, 'operator' => $operator, 'angkatan' => $angkatan, 'status' => $status]);
    }

    public function skripsilulus($angkatan, $status)
    {
        $operator = Operator::leftJoin('users', 'operator.iduser', '=', 'users.id')
            ->where('operator.iduser', Auth::user()->id)
            ->select('operator.nama', 'operator.nip', 'users.username')
            ->first();
        $mahasiswas = Mahasiswa::leftJoin('skripsi', function ($join) use ($status) {
            $join->on('mahasiswa.nim', '=', 'skripsi.nim')->where('skripsi.status', '=', 'verified');
        })
            ->join('dosen_wali', 'dosen_wali.nip', '=', 'mahasiswa.nip')
            ->where('mahasiswa.angkatan', $angkatan)
            ->where(function ($query) use ($status) {
                $query->where('skripsi.status', $status);
            })
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'skripsi.nilai', 'skripsi.status', 'skripsi.tanggal_sidang', 'skripsi.lama_studi', 'skripsi.scanSkripsi', 'dosen_wali.nama as dosen_nama')
            ->get();

        return view('operator.skripsilulus', ['mahasiswas' => $mahasiswas, 'operator' => $operator, 'angkatan' => $angkatan, 'status' => $status]);
    }

    public function skripsitidaklulus($angkatan, $status)
    {
        $operator = Operator::leftJoin('users', 'operator.iduser', '=', 'users.id')
            ->where('operator.iduser', Auth::user()->id)
            ->select('operator.nama', 'operator.nip', 'users.username')
            ->first();
        $mahasiswas = Mahasiswa::leftJoin('skripsi', function ($join) use ($status) {
            $join->on('mahasiswa.nim', '=', 'skripsi.nim')->where('skripsi.status', '=', 'verified');
        })
            ->join('dosen_wali', 'dosen_wali.nip', '=', 'mahasiswa.nip')
            ->where('mahasiswa.angkatan', $angkatan)
            ->where(function ($query) use ($status) {
                $query->whereNull('skripsi.nim')->orWhere(function ($query) use ($status) {
                    $query->where('skripsi.status', '=', $status);
                });
            })
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'skripsi.nilai', 'skripsi.status', 'skripsi.tanggal_sidang', 'skripsi.lama_studi', 'dosen_wali.nama as dosen_nama')
            ->get();
        return view('operator.skripsitidaklulus', ['mahasiswas' => $mahasiswas, 'operator' => $operator, 'angkatan' => $angkatan, 'status' => $status]);
    }

    public function PreviewListPKLLulus(Request $request, $angkatan, $status)
    {
        $mahasiswas = Mahasiswa::leftJoin('pkl', function ($join) use ($status) {
            $join->on('mahasiswa.nim', '=', 'pkl.nim')->where('pkl.status', '=', 'verified');
        })
            ->join('dosen_wali', 'dosen_wali.nip', '=', 'mahasiswa.nip')
            ->where('mahasiswa.angkatan', $angkatan)
            ->where(function ($query) use ($status) {
                $query->where('pkl.status', $status);
            })
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'pkl.nilai', 'pkl.statusPKL', 'pkl.status', 'dosen_wali.nama as dosen_nama')
            ->get();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('operator.downloadlistlulusPKL', ['mahasiswas' => $mahasiswas, 'status' => $status, 'angkatan' => $angkatan]);
        return $pdf->stream('daftar-list-pkl-lulus.pdf');

        if ($mahasiswas->isEmpty()) {
            // Lakukan penanganan jika $mahasiswas kosong, seperti menampilkan pesan atau mengarahkan ke halaman lain
            return redirect()
                ->back()
                ->with('error', 'Tidak ada data yang tersedia.');
        }
    }

    public function PreviewListPKLBelum(Request $request, $angkatan, $status)
    {
        $mahasiswas = Mahasiswa::leftJoin('pkl', function ($join) use ($status) {
            $join->on('mahasiswa.nim', '=', 'pkl.nim')->where('pkl.status', '=', 'verified');
        })
            ->join('dosen_wali', 'dosen_wali.nip', '=', 'mahasiswa.nip')
            ->where('mahasiswa.angkatan', $angkatan)
            ->where(function ($query) use ($status) {
                $query->whereNull('pkl.nim')->orWhere(function ($query) use ($status) {
                    $query->where('pkl.status', '=', $status);
                });
            })
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'pkl.nilai', 'pkl.status', 'dosen_wali.nama as dosen_nama')
            ->get();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('operator.downloadlisttidaklulusPKL', ['mahasiswas' => $mahasiswas, 'status' => $status, 'angkatan' => $angkatan]);
        return $pdf->stream('daftar-list-pkl-tidak-lulus.pdf');
    }

    public function PreviewListSkripsiLulus(Request $request, $angkatan, $status)
    {
        $mahasiswas = Mahasiswa::leftJoin('skripsi', function ($join) use ($status) {
            $join->on('mahasiswa.nim', '=', 'skripsi.nim')->where('skripsi.status', '=', 'verified');
        })
            ->join('dosen_wali', 'dosen_wali.nip', '=', 'mahasiswa.nip')
            ->where('mahasiswa.angkatan', $angkatan)
            ->where(function ($query) use ($status) {
                $query->where('skripsi.status', $status);
            })
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'skripsi.nilai', 'skripsi.statusSkripsi', 'skripsi.status', 'skripsi.tanggal_sidang', 'skripsi.lama_studi', 'dosen_wali.nama as dosen_nama')
            ->get();

        if ($mahasiswas->isEmpty()) {
            // Lakukan penanganan jika $mahasiswas kosong, seperti menampilkan pesan atau mengarahkan ke halaman lain
            return redirect()
                ->back()
                ->with('error', 'Tidak ada data yang tersedia.');
        }

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('operator.downloadlistlulusSkripsi', ['mahasiswas' => $mahasiswas, 'status' => $status, 'angkatan' => $angkatan]);
        return $pdf->stream('daftar-list-skripsi-lulus.pdf');
    }

    public function PreviewListSkripsiBelum(Request $request, $angkatan, $status)
    {
        $mahasiswas = Mahasiswa::leftJoin('skripsi', function ($join) use ($status) {
            $join->on('mahasiswa.nim', '=', 'skripsi.nim')->where('skripsi.status', '=', 'verified');
        })
            ->join('dosen_wali', 'dosen_wali.nip', '=', 'mahasiswa.nip')
            ->where('mahasiswa.angkatan', $angkatan)
            ->where(function ($query) use ($status) {
                $query->whereNull('skripsi.nim')->orWhere(function ($query) use ($status) {
                    $query->where('skripsi.status', '=', $status);
                });
            })
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'skripsi.nilai', 'skripsi.status', 'skripsi.tanggal_sidang', 'skripsi.lama_studi', 'dosen_wali.nama as dosen_nama')
            ->get();
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('operator.downloadlisttidaklulusSkripsi', ['mahasiswas' => $mahasiswas, 'status' => $status, 'angkatan' => $angkatan]);
        return $pdf->stream('daftar-list-skripsi-tidak-lulus.pdf');
    }

    public function PreviewListStatus(Request $request, $angkatan, $status)
    {
        $operator = Operator::leftJoin('users', 'operator.iduser', '=', 'users.id')
            ->where('operator.iduser', Auth::user()->id)
            ->select('operator.nama', 'operator.nip', 'users.username')
            ->first();
        $daftar = Mahasiswa::join('dosen_wali', 'dosen_wali.nip', '=', 'mahasiswa.nip')
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'dosen_wali.nama as dosen_nama')
            ->where('mahasiswa.angkatan', $angkatan)
            ->where('mahasiswa.status', $status)
            ->get();

        $namastatus = [
            'active' => 'Aktif',
            'lulus' => 'Lulus',
            'meninggal_dunia' => 'Meninggal Dunia',
            'do' => 'Drop Out',
            'cuti' => 'Cuti',
            'undur_diri' => 'Undur Diri',
            'mangkir' => 'Mangkir',
        ];

        $status_label = isset($namastatus[$status]) ? $namastatus[$status] : $status;
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('operator.downloadStatus', ['daftar' => $daftar, 'namastatus' => $status_label, 'operator' => $operator, 'angkatan' => $angkatan, 'status' => $status]);
        return $pdf->stream('daftar-list-status.pdf');
    }

    public function dataMahasiswa($nim)
    {
        $mahasiswa = Mahasiswa::join('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
            ->join('users', 'mahasiswa.iduser', '=', 'users.id')
            ->where('nim', $nim)
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'dosen_wali.nip as dosen_wali_nip', 'dosen_wali.nama as dosen_nama', 'users.foto')
            ->get();

        $irsData = IRS::join('mahasiswa', 'mahasiswa.nim', '=', 'irs.nim')
            ->where('irs.nim', $nim)
            ->select('mahasiswa.status as mhsstatus', 'irs.status as status', 'irs.semester_aktif', 'irs.jumlah_sks', 'irs.scanIRS')
            ->get()
            ->keyBy('semester_aktif'); // Gunakan semester_aktif sebagai kunci array

        $khsData = KHS::join('mahasiswa', 'mahasiswa.nim', '=', 'khs.nim')
            ->where('khs.nim', $nim)
            ->select('mahasiswa.status as mhsstatus', 'khs.status as status', 'khs.semester_aktif', 'khs.jumlah_sks', 'khs.jumlah_sks_kumulatif', 'khs.ip_semester', 'khs.ip_kumulatif')
            ->get()
            ->keyBy('semester_aktif');

        $pklData = PKL::join('mahasiswa', 'mahasiswa.nim', '=', 'pkl.nim')
            ->where('pkl.nim', $nim)
            ->select('mahasiswa.status as mhsstatus', 'pkl.status as status', 'pkl.semester_aktif', 'pkl.nilai', 'pkl.scanPKL')
            ->get()
            ->keyBy('semester_aktif');

        $skripsiData = Skripsi::join('mahasiswa', 'mahasiswa.nim', '=', 'skripsi.nim')
            ->where('skripsi.nim', $nim)
            ->select('mahasiswa.status as mhsstatus', 'skripsi.status as status', 'skripsi.semester_aktif', 'skripsi.nilai', 'skripsi.scanSkripsi', 'skripsi.lama_studi', 'skripsi.tanggal_sidang')
            ->get()
            ->keyBy('semester_aktif');

        $lastVerifiedPKL = PKL::join('mahasiswa', 'mahasiswa.nim', '=', 'pkl.nim')
            ->where('pkl.nim', $nim)
            ->where('pkl.status', 'verified')
            ->select('mahasiswa.status as mhsstatus', 'pkl.status as status', 'pkl.semester_aktif', 'pkl.nilai', 'pkl.scanPKL')
            ->orderBy('semester_aktif')
            ->first();

        return view('operator.details', [
            'mahasiswa' => $mahasiswa,
            'irsData' => $irsData,
            'khsData' => $khsData,
            'pklData' => $pklData,
            'skripsiData' => $skripsiData,
            'lastVerifiedPKL' => $lastVerifiedPKL,
        ]);
    }

    public function editMahasiswa(Request $request, $nim)
    {
        $user = Mahasiswa::where('nim', $nim)->first();

        $validated = $request->validate([
            // 'username' => 'nullable|string',
            // 'current_password' => 'nullable|string',
            'nama' => 'nullable|string',
            'nim' => 'nullable|string',
            'angkatan' => 'nullable|string',
            'status' => 'nullable|string',
            'jalur_masuk' => 'nullable|string',
            'nip2' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // if (!empty($validated['username'])) {
            //     Mahasiswa::where('nim', $nim)->update([
            //         'username' => $validated['username'],
            //     ]);
            // }

            if (!empty($validated['nama'])) {
                Mahasiswa::where('nim', $nim)->update([
                    'nama' => $validated['nama'],
                ]);
            }

            if (!empty($validated['nim'])) {
                Mahasiswa::where('nim', $nim)->update([
                    'nim' => $validated['nim'],
                ]);
            }

            if (!empty($validated['angkatan'])) {
                Mahasiswa::where('nim', $nim)->update([
                    'angkatan' => $validated['angkatan'],
                ]);
            }

            if (!empty($validated['status'])) {
                Mahasiswa::where('nim', $nim)->update([
                    'status' => $validated['status'],
                ]);
            }

            if (!empty($validated['jalur_masuk'])) {
                Mahasiswa::where('nim', $nim)->update([
                    'jalur_masuk' => $validated['jalur_masuk'],
                ]);
            }

            if (!empty($validated['nip2'])) {
                Mahasiswa::where('nim', $nim)->update([
                    'nip' => $validated['nip2'],
                ]);
            }

            // if (!empty($validated['current_password'])) {
            //     User::where('id', $request->user()->id)
            //         ->update([
            //             'password' => Hash::make($validated['current_password']),
            //         ]);
            // }

            DB::commit();

            return redirect()
                ->route('mahasiswa')
                ->with('success', 'Data mahasiswa berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('mahasiswa')
                ->with('error', 'Gagal memperbarui data mahasiswa.');
        }
    }
}
