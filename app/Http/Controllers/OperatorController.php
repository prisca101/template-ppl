<?php

namespace App\Http\Controllers;

use App\Models\Operator;
use App\Models\Dosen;
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

    public function edit(Request $request): View
    {
        $user = $request->user();
        $nip = $request->user()->operator->nip;
        $operators = Operator::join('users', 'operator.iduser', '=', 'users.id')
            ->where('nip', $nip)
            ->select('operator.nama', 'operator.nip', 'users.id', 'users.username', 'users.foto')
            ->first();
        return view('operator.profil', ['user' => $user, 'operators' => $operators]);
    }

    public function showEdit(Request $request): View
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
                    ->route('operator.showEdit')
                    ->with('error', 'Password lama tidak cocok.');
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
                ->route('edit')
                ->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('showEdit')
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

    // public function import(Request $request)
    // {
    //     //dd($request);
    //     $request->validate([
    //         'file' => 'required|mimes:xlsx', // Validasi file yang diunggah
    //     ]);
    //     //dd($request);
    //     $file = $request->file('file');
    //     //dd($file);

    //     if ($file) {
    //         if ($file->getClientOriginalExtension() !== 'xlsx') {
    //             return redirect('importMahasiswa')->with('error', 'File yang diunggah harus dalam format Excel XLSX.');
    //         }

    //         $data = Excel::toArray(new MahasiswaImport, $file)[0];

    //         foreach ($data as $row) {

    //             $validator = Validator::make($row, [
    //                 'nama' => 'required|regex:/^[a-zA-Z\s]+$/u', // Nama harus string tanpa angka dan simbol
    //                 'nim' => [
    //                     'required',
    //                     'string',
    //                     'regex:/^\d{1,20}$/',
    //                 ],
    //                 'angkatan' => 'required|integer',
    //                 'jalur_masuk' => [
    //                     'required',
    //                     'regex:/^(SNMPTN|SBMPTN|MANDIRI)$/', // Jalur masuk harus di antara tiga pilihan ini
    //                     'uppercase', // Tulisan harus kapital
    //                 ],
    //                 'nip' => 'required|exists:dosen_wali,nip',
    //             ]);

    //             // if ($validator->fails()) {
    //             //     return redirect('importMahasiswa')->withErrors($validator)->withInput();
    //             //     // Mengembalikan dengan error dan input sebelumnya jika validasi gagal
    //             // }

    //         }

    //         Excel::import(new MahasiswaImport, $file);
    //         return redirect('importMahasiswa')->with('success', 'Data Mahasiswa berhasil ditambahkan.');
    //     } else {
    //         return redirect('importMahasiswa')->with('error', 'Anda belum mengunggah file.');
    //     }
    // }

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
        return Excel::download(new MahasiswaExport(), 'mahasiswa.xlsx');
    }
    

    public function editMahasiswa(Request $request, $nim)
    {
        $user = Mahasiswa::where('nim', $nim)->first();

        $validated = $request->validate([
            'username' => 'nullable|string',
            'current_password' => 'nullable|string',
            'nama' => 'nullable|string',
            'nim' => 'nullable|string',
            'angkatan' => 'nullable|string',
            'status' => 'nullable|string',
            'jalur_masuk' => 'nullable|string',
            'nip2' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            if (!empty($validated['username'])) {
                Mahasiswa::where('nim', $nim)->update([
                    'username' => $validated['username'],
                ]);
            }

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

            if (!empty($validated['current_password'])) {
                Mahasiswa::where('nim', $nim)->join('users', 'mahasiswa.iduser', '=', 'users.id')->update([
                    'password' => Hash::make($validated['current_password']),
                ]);
            }

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
