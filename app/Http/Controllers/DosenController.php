<?php

namespace App\Http\Controllers;

use App\Models\IRS;
use App\Models\KHS;
use App\Models\PKL;
use App\Models\Skripsi;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Dompdf\Dompdf;
use Dompdf\Options;

class DosenController extends Controller
{
    public function detail(){
        $mahasiswaPerwalian = Mahasiswa::join('dosen_wali','mahasiswa.nip','=','dosen_wali.nip')
                ->join('users', 'mahasiswa.iduser', '=', 'users.id')
                ->where('dosen_wali.iduser', Auth::user()->id)
                ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'dosen_wali.nip as dosen_wali_nip', 'users.foto')
                ->get();
        return view('doswal.perwalian', [
            'mahasiswaPerwalian' => $mahasiswaPerwalian
        ]);
    }

    public function dataMahasiswa($nim){
        $mahasiswa =  Mahasiswa::join('dosen_wali','mahasiswa.nip','=','dosen_wali.nip')
            ->join('users', 'mahasiswa.iduser', '=', 'users.id')
            ->where('nim', $nim)
            ->where('dosen_wali.iduser', Auth::user()->id)
            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'dosen_wali.nip as dosen_wali_nip', 'dosen_wali.nama as dosen_nama','users.foto')
            ->get();

        $irsData = IRS::join('mahasiswa','mahasiswa.nim','=','irs.nim')
            ->where('irs.nim', $nim)
            ->select('mahasiswa.status as mhsstatus','irs.status as status', 'irs.semester_aktif','irs.jumlah_sks','irs.scanIRS')
            ->get()
            ->keyBy('semester_aktif'); // Gunakan semester_aktif sebagai kunci array

        $khsData = KHS::join('mahasiswa','mahasiswa.nim','=','khs.nim')
            ->where('khs.nim', $nim)
            ->select('mahasiswa.status as mhsstatus','khs.status as status', 'khs.semester_aktif','khs.jumlah_sks','khs.jumlah_sks_kumulatif','khs.ip_semester','khs.ip_kumulatif')
            ->get()
            ->keyBy('semester_aktif');

        $pklData = PKL::join('mahasiswa','mahasiswa.nim','=','pkl.nim')
            ->where('pkl.nim', $nim)
            ->select('mahasiswa.status as mhsstatus','pkl.status as status', 'pkl.semester_aktif', 'pkl.nilai','pkl.scanPKL')
            ->get()
            ->keyBy('semester_aktif');
    
        $skripsiData = Skripsi::join('mahasiswa','mahasiswa.nim','=','skripsi.nim')
            ->where('skripsi.nim', $nim)
            ->select('mahasiswa.status as mhsstatus','skripsi.status as status', 'skripsi.semester_aktif', 'skripsi.nilai','skripsi.scanSkripsi','skripsi.lama_studi','skripsi.tanggal_sidang')
            ->get()
            ->keyBy('semester_aktif');

        $lastVerifiedPKL = PKL::join('mahasiswa','mahasiswa.nim','=','pkl.nim')
            ->where('pkl.nim', $nim)
            ->where('pkl.status', 'verified')
            ->select('mahasiswa.status as mhsstatus','pkl.status as status', 'pkl.semester_aktif', 'pkl.nilai','pkl.scanPKL')
            ->orderBy('semester_aktif')
            ->first();

        return view('doswal.details', [
            'mahasiswa' => $mahasiswa,'irsData'=>$irsData, 'khsData'=>$khsData, 'pklData'=>$pklData,'skripsiData'=>$skripsiData,'lastVerifiedPKL'=>$lastVerifiedPKL,
        ]);
    }

    public function searchMhs(Request $request)
    {
        $search = $request->input('users-search');
        //dd($search);
        $mahasiswa = Mahasiswa::join('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
            ->join('users', 'mahasiswa.iduser', '=', 'users.id')
            ->where('dosen_wali.iduser', Auth::user()->id)
            ->where(function ($query) use ($search) {
                $query->where('mahasiswa.nama', 'like', '%' . $search . '%')
                    ->orWhere('mahasiswa.nim', 'like', '%' . $search . '%');
            })
            ->select('mahasiswa.nim', 'mahasiswa.nama')
            ->first();
        
        if ($mahasiswa) {
            return redirect()->route('details', ['nim' => $mahasiswa->nim]);
        } else {
            return redirect()->route('dosen.showEdit')->with('error', 'Tidak ada mahasiswa yang dicari di database');
        }
    }


    public function listPKL(Request $request){
        $nip = $request->user()->dosen->nip;
        $pkl = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
                ->join('mahasiswa','mahasiswa.nip','=','dosen_wali.nip')
                ->where('dosen_wali.nip',$nip)
                ->join('pkl','pkl.nim','=','mahasiswa.nim')
                ->select('mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','pkl.semester_aktif','pkl.scanPKL','pkl.nilai','pkl.status','pkl.statusPKL')
                ->get();
        return view('listPKL', ['pkl'=>$pkl]);
    }

    public function listSkripsi(Request $request){
        $nip = $request->user()->dosen->nip;
        $skripsi = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
                ->join('mahasiswa','mahasiswa.nip','=','dosen_wali.nip')
                ->where('dosen_wali.nip',$nip)
                ->join('skripsi','skripsi.nim','=','mahasiswa.nim')
                ->select('mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','skripsi.semester_aktif','skripsi.scanSkripsi','skripsi.nilai','skripsi.status','skripsi.statusSkripsi')
                ->get();
        return view('listSkripsi', ['skripsi'=>$skripsi]);
    }

    public function RekapPKL(Request $request){
        $nip = $request->user()->dosen->nip;
    
        $result = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
                ->join('mahasiswa', 'mahasiswa.nip', '=', 'dosen_wali.nip')
                ->join('pkl', 'pkl.nim', '=', 'mahasiswa.nim')
                ->where('dosen_wali.nip', $nip)
                ->where('pkl.nip', $nip) 
                ->select('mahasiswa.angkatan')
                ->selectRaw('SUM(CASE WHEN pkl.statusPKL = "lulus" THEN 1 ELSE 0 END) as luluspkl')
                ->selectRaw('SUM(CASE WHEN pkl.statusPKL = "tidak lulus" THEN 1 ELSE 0 END) as tdkluluspkl')
                ->groupBy('mahasiswa.angkatan')
                ->get();
    
        return view('RekapPKL', ['data' => $result]);
    }

    public function DownloadRekapPKL(Request $request) {
        $nip = $request->user()->dosen->nip;
    
        $result = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
            ->join('mahasiswa', 'mahasiswa.nip', '=', 'dosen_wali.nip')
            ->join('pkl', 'pkl.nim', '=', 'mahasiswa.nim')
            ->where('dosen_wali.nip', $nip)
            ->where('pkl.nip', $nip)
            ->select('mahasiswa.angkatan')
            ->selectRaw('SUM(CASE WHEN pkl.statusPKL = "lulus" THEN 1 ELSE 0 END) as luluspkl')
            ->selectRaw('SUM(CASE WHEN pkl.statusPKL = "tidak lulus" THEN 1 ELSE 0 END) as tdkluluspkl')
            ->groupBy('mahasiswa.angkatan')
            ->get();
    
        // Generate HTML view
        $html = view('DownloadRekapPKL', ['data' => $result])->render();

        // Generate PDF
        $pdf = new Dompdf();
        $pdf->loadHtml($html);

        // (Opsional) Set konfigurasi PDF
        $pdf->setPaper('A4', 'portrait');

        // Render PDF (generate)
        $pdf->render();

        // Save PDF file
        $pdfFileName = 'rekap_pkl_' . time() . '.pdf'; // Generate unique filename
        $pdf->stream(storage_path('app/public/pdfs/' . $pdfFileName)); // Simpan PDF di storage

        return view('DownloadRekapPKL', ['data' => $result, 'pdfFileName' => $pdfFileName]);
    }

    public function RekapSkripsi(Request $request){
        $nip = $request->user()->dosen->nip;
    
        $result = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
                ->join('mahasiswa', 'mahasiswa.nip', '=', 'dosen_wali.nip')
                ->join('skripsi', 'skripsi.nim', '=', 'mahasiswa.nim')
                ->where('dosen_wali.nip', $nip)
                ->where('skripsi.nip', $nip)
                ->select('mahasiswa.angkatan')
                ->selectRaw('SUM(CASE WHEN skripsi.statusSkripsi = "lulus" THEN 1 ELSE 0 END) as lulusskripsi')
                ->selectRaw('SUM(CASE WHEN skripsi.statusSkripsi = "tidak lulus" THEN 1 ELSE 0 END) as tdklulusskripsi')
                ->groupBy('mahasiswa.angkatan')
                ->get();
    
        return view('RekapSkripsi', ['data' => $result]);
    }
    
    public function DownloadRekapSkripsi(Request $request) {
        $nip = $request->user()->dosen->nip;
    
        $result = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
            ->join('mahasiswa', 'mahasiswa.nip', '=', 'dosen_wali.nip')
            ->join('skripsi', 'skripsi.nim', '=', 'mahasiswa.nim')
            ->where('dosen_wali.nip', $nip)
            ->where('skripsi.nip', $nip)
            ->select('mahasiswa.angkatan')
            ->selectRaw('SUM(CASE WHEN skripsi.statusSkripsi = "lulus" THEN 1 ELSE 0 END) as lulusskripsi')
            ->selectRaw('SUM(CASE WHEN skripsi.statusSkripsi = "tidak lulus" THEN 1 ELSE 0 END) as tdklulusskripsi')
            ->groupBy('mahasiswa.angkatan')
            ->get();
    
        // Generate HTML view
        $html = view('DownloadRekapSkripsi', ['data' => $result])->render();

        // Generate PDF
        $pdf = new Dompdf();
        $pdf->loadHtml($html);

        // (Opsional) Set konfigurasi PDF
        $pdf->setPaper('A4', 'portrait');

        // Render PDF (generate)
        $pdf->render();

        // Save PDF file
        $pdfFileName = 'rekap_skripsi_' . time() . '.pdf'; // Generate unique filename
        $pdf->stream(storage_path('app/public/pdfs/' . $pdfFileName)); // Simpan PDF di storage

        return view('DownloadRekapSkripsi', ['data' => $result, 'pdfFileName' => $pdfFileName]);
    }
    
    public function edit(Request $request)
    {
        $user = $request->user();
        $nip = $request->user()->dosen->nip;
        
        $dosens = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
            ->where('nip',$nip)
            ->select('dosen_wali.nama', 'dosen_wali.nip', 'users.id', 'users.username')
            ->first();
        return view('profilDosen', ['user' => $user, 'dosens' => $dosens]);
    }

    public function showEdit(Request $request)
    {
        $user = $request->user();
        $nip = $request->user()->dosen->nip;
        $dosens = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
            ->where('nip',$nip)
            ->select('dosen_wali.nama', 'dosen_wali.nip', 'users.id', 'users.username', 'users.password')
            ->first();
        return view('profilDosen-edit', ['user' => $user, 'dosens' => $dosens]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'username' => 'nullable|string',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8',
        ]);

        if ($request->has('foto')) {
            $fotoPath = $request->file('foto')->store('profile', 'public');
            $validated['foto'] = $fotoPath;

            $user->update([
                'foto' => $validated['foto'],
            ]);
        }

        if ($validated['new_password'] !== null) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return redirect()->route('dosen.showEdit')->with('error', 'Password lama tidak cocok.');
            }
        }

        DB::beginTransaction();

        try {
            $user->update([
                'username' => $validated['username'],
            ]);

            Dosen::where('iduser', $user->id)->update([
                'username' => $validated['username'],
            ]);

            if ($validated['new_password'] !== null) {
                $user->update([
                    'password' => Hash::make($validated['new_password'])
                ]);
            }

            DB::commit();

            return redirect()->route('dosen.edit')->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('dosen.showEdit')->with('error', 'Gagal memperbarui profil.');
        }
    }
}
