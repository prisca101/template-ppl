<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class IRSController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = Mahasiswa::leftJoin('users', 'mahasiswa.iduser', '=', 'users.id')
            ->leftJoin('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
            ->where('mahasiswa.iduser', Auth::user()->id)
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'users.username', 'dosen_wali.nama as dosen_nama', 'mahasiswa.jalur_masuk')
            ->first();

        $nim = $request->user()->mahasiswa->nim;
        $user = User::where('id', Auth::user()->id)
            ->select('foto')
            ->first();
        $latestIRS = IRS::where('nim', $nim)
            ->orderBy('semester_aktif', 'desc')
            ->first();
        $SemesterAktif = $latestIRS ? $latestIRS->semester_aktif : null;

        $irsData = IRS::where('nim', $nim);

        $semester = $request->input('semester_aktif');
        if ($semester) {
            $irsData->whereIn('semester_aktif', $semester);
        }

        $irsData = $irsData
            ->select('nim', 'status', 'jumlah_sks', 'semester_aktif', 'scanIRS')
            ->orderBy('semester_aktif', 'asc')
            ->get();

        return view('mahasiswa.irs', [
            'mahasiswa' => $mahasiswa,
            'irsData' => $irsData,
            'SemesterAktif' => $SemesterAktif,
        ]);
    }

    public function create(Request $request)
    {
        $nim = $request->user()->mahasiswa->nim; // Use the logged-in user to get the nim
        $mahasiswa = Mahasiswa::leftJoin('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
            ->where('mahasiswa.nim', $nim)
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'dosen_wali.nama as dosen_nama', 'dosen_wali.nip')
            ->first();

        if ($mahasiswa) {
            // Get the active semesters for the given student
            $latestIRS = IRS::where('nim', $nim)
                ->orderBy('semester_aktif', 'desc')
                ->first();
            $semesterAktifIRS = IRS::where('nim', $nim)
                ->pluck('semester_aktif')
                ->toArray();
            //dd($latestIRS, $semesterAktifIRS);
            // Create an array of available semesters by diffing the full range and active semesters
            $availableSemesters = array_diff(range(1, 14), $semesterAktifIRS);
        } else {
            // Handle the case where the Mahasiswa is not found
            return redirect()
                ->route('irs.index')
                ->with('error', 'Mahasiswa not found with the provided nim');
        }

        return view('mahasiswa.irs-create', compact('availableSemesters', 'mahasiswa'));
    }

    public function store(Request $request): RedirectResponse
    {
        //dd($request);
        $nim = $request->user()->mahasiswa->nim;
        $latestIRS = IRS::where('nim', $nim)
            ->orderBy('semester_aktif', 'desc')
            ->first();

        if ($latestIRS) {
            $latestSemester = $latestIRS->semester_aktif;
            $inputSemester = $request->input('semester_aktif');

            if ($inputSemester > $latestSemester + 1) {
                // IRS diisi tidak sesuai urutan, berikan pesan kesalahan
                return redirect()
                    ->route('irs.create')
                    ->with('error', 'Anda harus mengisi semester sebelumnya terlebih dahulu');
            }
        } elseif ($request->input('semester_aktif') != 1) {
            return redirect()
                ->route('irs.create')
                ->with('error', 'Anda harus memulai dengan IRS semester 1');
        }

        // Lanjutkan dengan validasi input
        $validated = $request->validate([
            'semester_aktif' => ['required', 'numeric'], // Correct the validation rule syntax
            'jumlah_sks' => ['required', 'numeric', 'between:1,24'], // Correct the validation rule syntax
            'scanIRS' => ['required', 'file', 'mimes:pdf', 'max:10240'], // Correct the validation rule syntax
        ]);

        // Lanjutkan dengan penyimpanan IRS
        $PDFPath = null;

        if ($request->hasFile('scanIRS') && $request->file('scanIRS')->isValid()) {
            $PDFPath = $request->file('scanIRS')->store('file', 'public');
        }

        $irs = new IRS();
        $irs->semester_aktif = $request->input('semester_aktif');
        $irs->jumlah_sks = $request->input('jumlah_sks');
        $irs->status = 'pending';
        $irs->scanIRS = $PDFPath; // Assign the PDF path here
        $irs->nim = $request->user()->mahasiswa->nim;
        $irs->nip = $request->user()->mahasiswa->nip;

        $saved = $irs->save();

        if ($saved) {
            return redirect()
                ->route('irs.index')
                ->with('success', 'IRS added successfully');
        } else {
            return redirect()
                ->route('irs.create')
                ->with('error', 'Failed to add IRS');
        }
    }

    public function getUpdateIrs(Request $request, $semester_aktif)
    {
        $user = $request->user();
        $nim = $request->user()->mahasiswa->nim;

        $mahasiswa = Mahasiswa::join('irs', 'mahasiswa.nim', 'irs.nim')
            ->where('semester_aktif', $semester_aktif)
            ->join('dosen_wali', 'mahasiswa.nip', 'dosen_wali.nip')
            ->select('irs.scanIRS', 'irs.jumlah_sks', 'irs.semester_aktif', 'mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'dosen_wali.nama as dosen_nama')
            ->first();

        return view('mahasiswa.irs-update', ['user' => $user, 'mahasiswa' => $mahasiswa]);
    }

    public function postUpdateIrs(Request $request, $semester_aktif)
    {
        $user = $request->user();
        $nim = $request->user()->mahasiswa->nim;

        $validated = $request->validate([
            'jumlah_sks' => 'nullable|numeric',
            'scanIRS' => 'max:10240|file|mimes:pdf',
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('scanIRS')) {
                $PDFPath = $request->file('scanIRS')->store('file', 'public');
                $validated['scanIRS'] = $PDFPath;

                IRS::where([
                    'nim' => $nim,
                    'semester_aktif' => $semester_aktif,
                ])->update([
                    'scanIRS' => $validated['scanIRS'],
                ]);
            }

            if (!empty($validated['jumlah_sks'])) {
                IRS::where([
                    'nim' => $nim,
                    'semester_aktif' => $semester_aktif,
                ])->update([
                    'jumlah_sks' => $validated['jumlah_sks'],
                ]);
            }

            IRS::where([
                'nim' => $nim,
                'semester_aktif' => $semester_aktif,
            ])->update([
                'status' => 'pending',
            ]);

            DB::commit();

            return redirect()
                ->route('irs.index')
                ->with('success', 'Data IRS berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('irs.getIrs', ['semester_aktif' => $semester_aktif])
                ->with('error', 'Gagal memperbarui IRS');
        }
    }

    public function status(Request $request)
    {
        return view('login');
    }
}
