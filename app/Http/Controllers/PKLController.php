<?php

namespace App\Http\Controllers;

use App\Models\PKL;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class PKLController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = Mahasiswa::leftJoin('users', 'mahasiswa.iduser', '=', 'users.id')
            ->leftJoin('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
            ->where('mahasiswa.iduser', Auth::user()->id)
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'users.username', 'dosen_wali.nama as dosen_nama', 'mahasiswa.jalur_masuk')
            ->first();
        $nim = $request->user()->mahasiswa->nim;
        $pklData = PKL::where('nim', $nim);

        $semester = $request->input('semester_aktif');
        if ($semester) {
            $pklData->whereIn('semester_aktif', $semester);
        }

        $pklData = $pklData->select('nim', 'status', 'scanPKL', 'nilai', 'statusPKL', 'status', 'semester_aktif')->get();

        return view('mahasiswa.pkl', [
            'mahasiswa' => $mahasiswa,
            'pklData' => $pklData,
        ]);
    }

    public function create(Request $request)
    {
        $nim = $request->user()->mahasiswa->nim; // Use the logged-in user to get the nim
        $mahasiswa = Mahasiswa::leftJoin('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
            ->where('mahasiswa.nim', $nim)
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'dosen_wali.nama as dosen_nama', 'dosen_wali.nip')
            ->first();
        // Periksa apakah data PKL sudah ada untuk semester yang dipilih
        $existingPKL = PKL::where('nim', $nim)->first();

        if ($existingPKL) {
            return redirect()->route('pkl.index')->with('error', 'Anda telah memasukkan progress PKL');
        }

        if ($mahasiswa) {
            // Get the active semesters for the given student
            $semesterAktifPKL = PKL::where('nim', $nim)
                ->pluck('semester_aktif')
                ->toArray();

            // Create an array of available semesters by diffing the full range and active semesters
            $availableSemesters = array_diff(range(6, 14), $semesterAktifPKL);
        } else {
            // Handle the case where the Mahasiswa is not found
            return redirect()
                ->route('pkl.index')
                ->with('error', 'Mahasiswa not found with the provided nim.');
        }

        return view('mahasiswa.pkl-create', compact('availableSemesters', 'mahasiswa'));
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'semester_aktif' => ['required', 'numeric'],
                'nilai' => [Rule::in(['A', 'B', 'C', 'D', 'E'])],
                'scanPKL' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            ]);

            $PDFPath = null;

            if ($request->hasFile('scanPKL') && $request->file('scanPKL')->isValid()) {
                $PDFPath = $request->file('scanPKL')->store('file', 'public');
            }

            $pkl = new PKL();
            $pkl->semester_aktif = $validated['semester_aktif'];
            $pkl->statusPKL = $request->input('statusPKL');
            $pkl->nilai = $validated['nilai'];
            $pkl->status = 'pending';
            $pkl->scanPKL = $PDFPath; // Assign the PDF path here
            $pkl->nim = $request->user()->mahasiswa->nim;
            $pkl->nip = $request->user()->mahasiswa->nip;
            $saved = $pkl->save();

            if ($saved) {
                return redirect()
                    ->route('pkl.index')
                    ->with('success', 'PKL added successfully');
            } else {
                return redirect()
                    ->route('pkl.create')
                    ->with('error', 'Failed to add PKL');
            }
        } catch (\Exception $e) {
            return redirect()
                ->route('pkl.create')
                ->with('error', $e->getMessage());
        }
    }

    private function update(Request $request, PKL $existingPKL): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'nilai' => [Rule::in(['A', 'B', 'C', 'D', 'E'])],
                'scanPKL' => ['required', 'file', 'mimes:pdf', 'max:10240'],
            ]);

            $PDFPath = null;

            if ($request->hasFile('scanPKL') && $request->file('scanPKL')->isValid()) {
                $PDFPath = $request->file('scanPKL')->store('file', 'public');
            }

            $existingPKL->statusPKL = $request->input('statusPKL');
            $existingPKL->nilai = $validated['nilai'];
            $existingPKL->status = 'pending';
            $existingPKL->scanPKL = $PDFPath; // Assign the PDF path here
            $saved = $existingPKL->save();

            if ($saved) {
                return redirect()
                    ->route('pkl.index')
                    ->with('success', 'PKL updated successfully');
            } else {
                return redirect()
                    ->route('pkl.create')
                    ->with('error', 'Failed to update PKL');
            }
        } catch (\Exception $e) {
            return redirect()
                ->route('pkl.create')
                ->with('error', 'An error occurred while updating PKL: ' . $e->getMessage());
        }
    }

    public function getUpdatePkl(Request $request, $semester_aktif)
    {
        $user = $request->user();
        $nim = $request->user()->mahasiswa->nim;

        $mahasiswa = Mahasiswa::join('pkl', 'mahasiswa.nim', 'pkl.nim')
            ->where('semester_aktif', $semester_aktif)
            ->join('dosen_wali', 'mahasiswa.nip', 'dosen_wali.nip')
            ->select('pkl.scanPKL', 'pkl.statusPKL', 'pkl.semester_aktif', 'pkl.nilai', 'mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'dosen_wali.nama as dosen_nama')
            ->first();

        return view('mahasiswa.pkl-update', ['user' => $user, 'mahasiswa' => $mahasiswa]);
    }

    public function postUpdatePKL(Request $request, $semester_aktif)
    {
        $user = $request->user();
        $nim = $request->user()->mahasiswa->nim;

        $validated = $request->validate([
            'scanPKL' => 'max:10240|file|mimes:pdf',
            'nilai' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('scanPKL')) {
                $PDFPath = $request->file('scanPKL')->store('file', 'public');
                $validated['scanPKL'] = $PDFPath;

                PKL::where([
                    'nim' => $nim,
                    'semester_aktif' => $semester_aktif,
                ])->update([
                    'scanPKL' => $validated['scanPKL'],
                ]);
            }

            if (!empty($validated['nilai'])) {
                PKL::where([
                    'nim' => $nim,
                    'semester_aktif' => $semester_aktif,
                ])->update([
                    'nilai' => $validated['nilai'],
                ]);
            }

            PKL::where([
                'nim' => $nim,
                'semester_aktif' => $semester_aktif,
            ])->update([
                'status' => 'pending',
            ]);

            DB::commit();

            return redirect()
                ->route('pkl.index') // Assuming you have a route for PKL
                ->with('success', 'Data PKL berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('pkl.getPkl', ['semester_aktif' => $semester_aktif]) // Adjust this route as needed
                ->with('error', 'Gagal memperbarui PKL');
        }
    }
}
