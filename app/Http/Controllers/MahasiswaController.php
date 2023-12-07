<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\IRS;
use App\Models\KHS;
use App\Models\PKL;
use App\Models\Skripsi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    //ini bagian profil sekali pakai
    public function edit(Request $request): View
    {
        $user = $request->user();
        $nim = $request->user()->mahasiswa->nim;
        $mahasiswas = Mahasiswa::join('users', 'mahasiswa.iduser', '=', 'users.id')
            ->where('nim', $nim)
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'mahasiswa.nip', 'mahasiswa.alamat', 'mahasiswa.kabkota', 'mahasiswa.provinsi', 'mahasiswa.noHandphone', 'users.id', 'users.username', 'users.password','users.foto')
            ->first();
        return view('mahasiswa.profil', ['user' => $user, 'mahasiswas' => $mahasiswas]);
    }

    public function showEdit(Request $request): View
    {
        $user = $request->user();
        $nim = $request->user()->mahasiswa->nim;
        $mahasiswas = Mahasiswa::join('users', 'mahasiswa.iduser', '=', 'users.id')
            ->where('nim', $nim)
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'mahasiswa.nip', 'mahasiswa.alamat', 'mahasiswa.kabkota', 'mahasiswa.provinsi', 'mahasiswa.noHandphone', 'users.id', 'users.username', 'users.password','users.foto')
            ->first();
        return view('mahasiswa.profil-edit', ['user' => $user, 'mahasiswas' => $mahasiswas]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'alamat' => 'nullable|string',
            'kabkota' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'noHandphone' => 'nullable|string',
            'username' => 'nullable|string',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8',
            'new_confirm_password' => 'nullable|same:new_password',
            'foto' => 'max:10240|image|mimes:jpeg,png,jpg',
        ]);
        //dd($validated);

        if ($request->has('foto')) {
            $fotoPath = $request->file('foto')->store('profile', 'public');
            $validated['foto'] = $fotoPath;
        
            $user->update([
                'foto' => $validated['foto'],
            ]);
        }
        
        if (isset($validated['new_password']) && $validated['new_password'] !== null) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return redirect()->route('operator.showEdit')->with('error', 'Password lama tidak cocok.');
            }
        }
        //dd($validated);
        DB::beginTransaction();
        
        try {
            $user->update([
                'username' => $validated['username'],
                'cekProfil' => 1,
            ]);
        
            $mahasiswa = Mahasiswa::where('iduser', $user->id)->first();
        
            if ($mahasiswa) {
                $mahasiswa->update([
                    'username' => $validated['username'],
                    'alamat' => $validated['alamat'],
                    'kabkota' => $validated['kabkota'],
                    'provinsi' => $validated['provinsi'],
                    'noHandphone' => $validated['noHandphone'],
                ]);
            } else {
                // Handle if Mahasiswa is not found for the user
            }
        
            if (!empty($validated['new_password'])) {
                $user->update([
                    'password' => Hash::make($validated['new_password']),
                ]);
            }
        
            DB::commit();
        
            return redirect()
                ->route('mhs.edit')
                ->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('mhs.showEdit')
                ->with('error', 'Gagal memperbarui profil.');
        }
    }

    //ini yang bagian profil mahasiswa
    public function edit2(Request $request): View
    {
        $user = $request->user();
        $nim = $request->user()->mahasiswa->nim;
        $mahasiswas = Mahasiswa::join('users', 'mahasiswa.iduser', '=', 'users.id')
            ->where('nim', $nim)
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'mahasiswa.nip', 'mahasiswa.alamat', 'mahasiswa.kabkota', 'mahasiswa.provinsi', 'mahasiswa.noHandphone', 'users.id', 'users.username', 'users.password','users.foto')
            ->first();
        return view('mahasiswa.profil2', ['user' => $user, 'mahasiswas' => $mahasiswas]);
    }


    public function showEdit2(Request $request): View
    {
        $user = $request->user();
        $nim = $request->user()->mahasiswa->nim;
        $mahasiswas = Mahasiswa::join('users', 'mahasiswa.iduser', '=', 'users.id')
            ->where('nim', $nim)
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'mahasiswa.nip', 'mahasiswa.alamat', 'mahasiswa.kabkota', 'mahasiswa.provinsi', 'mahasiswa.noHandphone', 'users.id', 'users.username', 'users.password','users.foto')
            ->first();
        return view('mahasiswa.profil-edit2', ['user' => $user, 'mahasiswas' => $mahasiswas]);
    }

    public function update2(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'alamat' => 'nullable|string',
            'kabkota' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'noHandphone' => 'nullable|string',
            'username' => 'nullable|string',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8',
            'new_confirm_password' => 'nullable|same:new_password',
            'foto' => 'max:10240|image|mimes:jpeg,png,jpg',
        ]);
        //dd($validated);

        if ($request->has('foto')) {
            $fotoPath = $request->file('foto')->store('profile', 'public');
            $validated['foto'] = $fotoPath;
        
            $user->update([
                'foto' => $validated['foto'],
            ]);
        }
        
        if (isset($validated['new_password']) && $validated['new_password'] !== null) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return redirect()->route('operator.showEdit')->with('error', 'Password lama tidak cocok.');
            }
        }
        //dd($validated);
        DB::beginTransaction();
        
        try {
            $user->update([
                'username' => $validated['username'],
                'cekProfil' => 1,
            ]);
        
            $mahasiswa = Mahasiswa::where('iduser', $user->id)->first();
        
            if ($mahasiswa) {
                $mahasiswa->update([
                    'username' => $validated['username'],
                    'alamat' => $validated['alamat'],
                    'kabkota' => $validated['kabkota'],
                    'provinsi' => $validated['provinsi'],
                    'noHandphone' => $validated['noHandphone'],
                ]);
            } else {
                // Handle if Mahasiswa is not found for the user
            }
        
            if (!empty($validated['new_password'])) {
                $user->update([
                    'password' => Hash::make($validated['new_password']),
                ]);
            }
        
            DB::commit();
        
            return redirect()
                ->route('mhs.edit2')
                ->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('mhs.showEdit2')
                ->with('error', 'Gagal memperbarui profil.');
        }
    }
    
}
