<?php

namespace App\Http\Controllers;

use App\Models\KHS;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class KHSController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = Mahasiswa::leftJoin('users', 'mahasiswa.iduser', '=', 'users.id')
                ->leftJoin('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
                ->where('mahasiswa.iduser', Auth::user()->id)
                ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'users.username', 'dosen_wali.nama as dosen_nama','mahasiswa.jalur_masuk')
                ->first();
        $nim = $request->user()->mahasiswa->nim;
        $user = User::where('id', Auth::user()->id)->select('foto')->first();
        $latestKHS = KHS::where('nim',$nim)
                    ->orderBy('created_at', 'desc')->first();
        $IPKumulatif = $latestKHS ? $latestKHS->ip_kumulatif : null;
        $JumlahSKSKumulatif = $latestKHS ? $latestKHS->jumlah_sks_kumulatif : null;


        // // Ambil NIM dari Mahasiswa yang saat ini sudah login
        $nim = $request->user()->mahasiswa->nim;

        $khsData = KHS::where('nim', $nim);

        $semester = $request->input('semester_aktif');
        if ($semester) {
            $khsData->whereIn('semester_aktif', $semester);
        }

        $khsData = $khsData->select('nim', 'status', 'jumlah_sks', 'jumlah_sks_kumulatif','semester_aktif', 'ip_semester','ip_kumulatif','scanKHS')->get();

        return view('mahasiswa.khs', [
            'mahasiswa' => $mahasiswa,
            'khsData' => $khsData,
            'IPKumulatif' => $IPKumulatif,
            'JumlahSKSKumulatif' => $JumlahSKSKumulatif
        ]);

        // $mahasiswa = Mahasiswa::select('nama', 'nim')->get();
        // $nim = $request->user()->mahasiswa->nim;
        // $khsData = KHS::where('nim',$nim)
        //         ->select('nim', 'status', 'jumlah_sks', 'semester_aktif','jumlah_sks_kumulatif','ip_semester','ip_kumulatif','scanKHS')
        //         ->get();

        // return view('mahasiswa.khs', [
        //     'mahasiswa' => $mahasiswa,
        //     'khsData' => $khsData,
        // ]);
    }

    public function create(Request $request)
    {
        $nim = $request->user()->mahasiswa->nim; // Use the logged-in user to get the nim
        $mahasiswa = Mahasiswa::leftJoin('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
                            ->where('mahasiswa.nim', $nim)
                            ->select('mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','dosen_wali.nama as dosen_nama', 'dosen_wali.nip')
                            ->first();

        if ($mahasiswa) {
            // Get the active semesters for the given student
            $latestKHS = KHS::where('nim', $nim)->orderBy('semester_aktif', 'desc')->first();
            $semesterAktifKHS = KHS::where('nim', $nim)->pluck('semester_aktif')->toArray();

            // Create an array of available semesters by diffing the full range and active semesters
            $availableSemesters = array_diff(range(1, 14), $semesterAktifKHS);
        } else {
            // Handle the case where the Mahasiswa is not found
            return redirect()->route('khs.index')->with('error', 'Mahasiswa not found with the provided nim.');
        }
        
        return view('mahasiswa.khs-create', compact('availableSemesters', 'mahasiswa'));
    }

    public function store(Request $request): RedirectResponse
    {   
        $nim = $request->user()->mahasiswa->nim;
        $latestKHS = KHS::where('nim', $nim)->orderBy('semester_aktif', 'desc')->first();

        if ($latestKHS) {
            $latestSemester = $latestKHS->semester_aktif;
            $inputSemester = $request->input('semester_aktif');
            
            if ($inputSemester > $latestSemester + 1) {
                // KHS diisi tidak sesuai urutan, berikan pesan kesalahan
                
                return redirect()->route('khs.create')->with('error', 'Anda harus mengisi KHS sesuai urutan semester.');
            }
        } elseif ($request->input('semester_aktif') != 1) {
            return redirect()->route('khs.create')->with('error', 'Anda harus memulai dengan KHS semester 1.');
        }
        
        $validated = $request->validate([
            'semester_aktif' => ['required', 'numeric'], // Correct the validation rule syntax
            'jumlah_sks' => ['required', 'numeric', 'between:18,24'], // Correct the validation rule syntax
            'jumlah_sks_kumulatif' => ['required', 'numeric', 'between:18,144'],
            'ip_semester' => ['required'],
            'ip_kumulatif' =>['required'],
            'scanKHS' => ['required', 'file', 'mimes:pdf', 'max:10240'], // Correct the validation rule syntax
        ]);

        $PDFPath = null;

        if ($request->hasFile('scanKHS') && $request->file('scanKHS')->isValid()) {
            $PDFPath = $request->file('scanKHS')->store('file', 'public');
        }

        $khs = new KHS();
        $khs->semester_aktif = $request->input('semester_aktif');
        $khs->jumlah_sks = $request->input('jumlah_sks');
        $khs->jumlah_sks_kumulatif = $request->input('jumlah_sks_kumulatif');
        $khs->ip_semester = $request->input('ip_semester');
        $khs->ip_kumulatif = $request->input('ip_kumulatif');
        $khs->status = 'pending';
        $khs->scanKHS = $PDFPath; // Assign the PDF path here
        $khs->nim = $request->user()->mahasiswa->nim;
        $khs->nip = $request->user()->mahasiswa->nip;
        $saved = $khs->save();

        if ($saved) {
            return redirect()->route('khs.index')->with('success', 'KHS added successfully');
        } else {
            return redirect()->route('khs.create')->with('error', 'Failed to add KHS');
        }
    }

}
