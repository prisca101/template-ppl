<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\IRS;
use App\Models\KHS;
use App\Models\PKL;
use App\Models\Skripsi;
use Illuminate\Validation\Rule;

class VerifikasiController extends Controller
{
    public function showAll(Request $request)
    {        
        $nip = $request->user()->dosen->nip;
        $dosens = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
            ->where('nip', $nip)
            ->select('dosen_wali.nama', 'dosen_wali.nip', 'users.id', 'users.username', 'users.foto')
            ->first();
        $irs = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
                ->join('mahasiswa','mahasiswa.nip','=','dosen_wali.nip')
                ->where('dosen_wali.nip',$nip)
                ->join('irs','irs.nim','=','mahasiswa.nim')
                ->where('irs.status','pending')
                ->select('irs.idirs','mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','irs.semester_aktif','irs.jumlah_sks','irs.scanIRS')
                ->get();
        $khs = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
                ->join('mahasiswa','mahasiswa.nip','=','dosen_wali.nip')
                ->where('dosen_wali.nip',$nip)
                ->join('khs','khs.nim','=','mahasiswa.nim')
                ->where('khs.status','pending')
                ->select('khs.idkhs','mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','khs.semester_aktif','khs.jumlah_sks','khs.scanKHS','khs.jumlah_sks_kumulatif','khs.ip_semester','khs.ip_kumulatif')
                ->get();
        $pkl = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
                ->join('mahasiswa','mahasiswa.nip','=','dosen_wali.nip')
                ->where('dosen_wali.nip',$nip)
                ->join('pkl','pkl.nim','=','mahasiswa.nim')
                ->where('pkl.status','pending')
                ->select('pkl.idpkl','mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','pkl.semester_aktif','pkl.scanPKL','pkl.nilai','pkl.statusPKL')
                ->get();
        $skripsi = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
                ->join('mahasiswa','mahasiswa.nip','=','dosen_wali.nip')
                ->where('dosen_wali.nip',$nip)
                ->join('skripsi','skripsi.nim','=','mahasiswa.nim')
                ->where('skripsi.status','pending')
                ->select('skripsi.idskripsi','mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','skripsi.semester_aktif','skripsi.scanSkripsi','skripsi.nilai','skripsi.statusSkripsi','skripsi.lama_studi','skripsi.tanggal_sidang')
                ->get();
        return view('doswal.verification', ['irs'=>$irs,'khs'=>$khs,'pkl'=>$pkl,'skripsi'=>$skripsi,'dosens'=>$dosens]);
    }

    public function verifikasi(Request $request,$nim, $semester_aktif)
    {
        $irs = IRS::where('nim', $nim)
                ->where('semester_aktif', $semester_aktif)
                ->first();
        
        if ($irs) {
            IRS::where('nim', $irs->nim)
            ->where('semester_aktif', $semester_aktif)
            ->update(['status' => 'verified']);
            return redirect()->route('showAll')->with('success', 'IRS berhasil diverifikasi.');
        }
        else {
            return redirect()->route('showAll')->with('error', 'Tidak dapat memverifikasi.');
        }
    }

    public function rejected(Request $request, $nim,$semester_aktif){
        $irs = IRS::where('nim', $nim)
                ->where('semester_aktif', $semester_aktif)
                ->first();
    
        if ($irs) {
            $irs->delete();
            return redirect()->route('showAll')->with('success', 'IRS berhasil dihapus.');
        }
        else {
            return redirect()->route('showAll')->with('error', 'Tidak dapat menghapus.');
        }
    }

    public function vieweditIRS(Request $request,$idirs){
        $nip = $request->user()->dosen->nip;
        $dosens = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
            ->where('nip', $nip)
            ->select('dosen_wali.nama', 'dosen_wali.nip', 'users.id', 'users.username', 'users.foto')
            ->first();
        $irs = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
        ->join('mahasiswa','mahasiswa.nip','=','dosen_wali.nip')
        ->where('dosen_wali.nip',$nip)
        ->join('irs','irs.nim','=','mahasiswa.nim')
        ->where('irs.idirs',$idirs)
        ->where('irs.status','pending')
        ->select('irs.idirs','mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','irs.semester_aktif','irs.jumlah_sks','irs.scanIRS')
        ->first();

        return view('doswal.vieweditIRS',['irs'=>$irs,'dosens'=>$dosens]);
    }

    public function editIRS(Request $request,$idirs)
    {
        // Mendapatkan IRS berdasarkan nim dan semester aktif
        $irs = IRS::join('mahasiswa','irs.nim','=','mahasiswa.nim')
        ->where('irs.idirs',$idirs)
        ->where('irs.status','pending')
        ->select('irs.idirs','mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','irs.semester_aktif','irs.jumlah_sks','irs.scanIRS')
        ->first();

        // Melakukan validasi setelah menyesuaikan nilai semester_aktif
        $validated = $request->validate([
            'semester_aktif' => ['required', 'numeric'], // Correct the validation rule syntax
            'jumlah_sks' => ['required', 'numeric', 'between:18,24'], // Correct the validation rule syntax
            
        ]);

        if ($irs) {
            $irs->jumlah_sks = $validated['jumlah_sks'];
            $irs->semester_aktif = $validated['semester_aktif'];
            
            $irs->save();

            return redirect()->route('showAll')->with('success', 'IRS berhasil diubah.');
        } else{
            return redirect()->route('showAll')->with('error', 'Terdapat error pada IRS.');
        }
    }

    public function verifikasiKHS(Request $request, $nim, $semester_aktif)
    {
        $khs = KHS::where('nim', $nim)
                ->where('semester_aktif', $semester_aktif)
                ->first();

        if($khs){
            KHS::where('nim', $khs->nim)
            ->where('semester_aktif', $semester_aktif)
            ->update(['status' => 'verified']);
            return redirect()->route('showAll')->with('success', 'KHS berhasil diverifikasi.');
        }
        else {
            return redirect()->route('showAll')->with('error', 'Tidak dapat memverifikasi.');
        }
    }

    public function rejectedKHS(Request $request, $nim,$semester_aktif){
        $khs = KHS::where('nim', $nim)
                ->where('semester_aktif', $semester_aktif)
                ->first();

        if ($khs) {
            $khs->delete();
            return redirect()->route('showAll')->with('success', 'KHS berhasil dihapus.');
        }
        else {
            return redirect()->route('showAll')->with('error', 'Tidak dapat menghapus.');
        }
    }

    public function vieweditKHS(Request $request, $idkhs){
        $nip = $request->user()->dosen->nip;
        $dosens = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
            ->where('nip', $nip)
            ->select('dosen_wali.nama', 'dosen_wali.nip', 'users.id', 'users.username', 'users.foto')
            ->first();
        $khs = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
        ->join('mahasiswa','mahasiswa.nip','=','dosen_wali.nip')
        ->where('dosen_wali.nip',$nip)
        ->join('khs','khs.nim','=','mahasiswa.nim')
        ->where('khs.status','pending')
        ->where('khs.idkhs',$idkhs)
        ->select('khs.idkhs','mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','khs.semester_aktif','khs.jumlah_sks','khs.scanKHS','khs.jumlah_sks_kumulatif','khs.ip_semester','khs.ip_kumulatif')
        ->first();


        return view('doswal.vieweditKHS',['khs'=>$khs,'dosens'=>$dosens]);
    }

    public function editKHS(Request $request, $idkhs)
    {
        // Mendapatkan IRS berdasarkan nim dan semester aktif
        
        $khs = KHS::join('mahasiswa','khs.nim','=','mahasiswa.nim')
        ->where('khs.idkhs',$idkhs)
        ->where('khs.status','pending')
        ->select('khs.idkhs','mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','khs.semester_aktif','khs.jumlah_sks','khs.scanKHS','khs.jumlah_sks_kumulatif','khs.ip_semester','khs.ip_kumulatif')
        ->first();

        // Melakukan validasi setelah menyesuaikan nilai semester_aktif
        $validated = $request->validate([
            'semester_aktif' => ['required', 'numeric'], // Correct the validation rule syntax
            'jumlah_sks' => ['required', 'numeric', 'between:18,24'],
            'jumlah_sks_kumulatif' =>['required', 'numeric', 'between:18,24'],
            'ip_semester' =>['required', 'numeric', 'max:4'],
            'ip_kumulatif' =>['required', 'numeric', 'max:4'],
            
        ]);

        if ($khs) {
            $khs->jumlah_sks = $validated['jumlah_sks'];
            $khs->semester_aktif = $validated['semester_aktif'];
            $khs->ip_semester = $validated['ip_semester'];
            $khs->ip_kumulatif = $validated['ip_kumulatif'];
            $khs->jumlah_sks_kumulatif = $validated['jumlah_sks_kumulatif'];
            $khs->save();

            return redirect()->route('showAll')->with('success', 'KHS berhasil diubah.');
        } else{
            return redirect()->route('showAll')->with('error', 'Terdapat error pada KHS');
        }
    }

    public function verifikasiPKL(Request $request, $nim, $semester_aktif)
    {
        $pkl = PKL::where('nim', $nim)
                ->where('semester_aktif', $semester_aktif)
                ->first();

        if($pkl){
            PKL::where('nim', $pkl->nim)
            ->where('semester_aktif', $semester_aktif)
            ->update(['status' => 'verified']);
            return redirect()->route('showAll')->with('success', 'PKL berhasil diverifikasi.');
        }
        else {
            return redirect()->route('showAll')->with('error', 'Tidak dapat memverifikasi.');
        }
    }

    public function rejectedPKL(Request $request, $nim,$semester_aktif){
        $pkl = PKL::where('nim', $nim)
                ->where('semester_aktif', $semester_aktif)
                ->first();

        if ($pkl) {
            $pkl->delete();
            return redirect()->route('showAll')->with('success', 'PKL berhasil dihapus.');
        }
        else {
            return redirect()->route('showAll')->with('error', 'Tidak dapat menghapus.');
        }
    }

    public function vieweditPKL(Request $request,$idpkl){
        $nip = $request->user()->dosen->nip;
        $dosens = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
            ->where('nip', $nip)
            ->select('dosen_wali.nama', 'dosen_wali.nip', 'users.id', 'users.username', 'users.foto')
            ->first();
        $pkl = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
                ->join('mahasiswa','mahasiswa.nip','=','dosen_wali.nip')
                ->where('dosen_wali.nip',$nip)
                ->join('pkl','pkl.nim','=','mahasiswa.nim')
                ->where('pkl.status','pending')
                ->where('pkl.idpkl',$idpkl)
                ->select('pkl.idpkl','mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','pkl.semester_aktif','pkl.scanPKL','pkl.nilai','pkl.statusPKL')
                ->first();
        return view('doswal.vieweditPKL',['pkl'=>$pkl,'dosens'=>$dosens]);
    }

    public function editPKL(Request $request, $idpkl)
    {
        
        $pkl = PKL::join('mahasiswa','pkl.nim','=','mahasiswa.nim')
        ->where('pkl.idpkl',$idpkl)
        ->where('pkl.status','pending')
        ->select('pkl.idpkl','mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','pkl.semester_aktif','pkl.scanPKL','pkl.nilai','pkl.statusPKL')
        ->first();

        // Melakukan validasi setelah menyesuaikan nilai semester_aktif
        $validated = $request->validate([
            'nilai' => [Rule::in(['A', 'B', 'C', 'D', 'E'])],
            'semester_aktif' => ['required', 'numeric'],
        ]);

        if ($pkl) {
            $pkl->nilai = $validated['nilai'];
            $pkl->semester_aktif = $validated['semester_aktif'];
            $pkl->save();

            return redirect()->route('showAll')->with('success', 'PKL berhasil diubah.');
        } else{
            return redirect()->route('showAll')->with('error', 'Terdapat error pada PKL');
        }
    }
    
    public function verifikasiSkripsi(Request $request, $nim, $semester_aktif)
    {
        $skripsi = Skripsi::where('nim', $nim)
                ->where('semester_aktif', $semester_aktif)
                ->first();

        if($skripsi){
            Skripsi::where('nim', $skripsi->nim)
            ->where('semester_aktif', $semester_aktif)
            ->update(['status' => 'verified']);
            return redirect()->route('showAll')->with('success', 'Skripsi berhasil diverifikasi.');
        }
        else {
            return redirect()->route('showAll')->with('error', 'Tidak dapat memverifikasi.');
        }
    }

    public function rejectedSkripsi(Request $request, $nim,$semester_aktif){
        $skripsi = Skripsi::where('nim', $nim)
                ->where('semester_aktif', $semester_aktif)
                ->first();

        if ($skripsi) {
            $skripsi->delete();
            return redirect()->route('showAll')->with('success', 'Skripsi berhasil dihapus.');
        }
        else {
            return redirect()->route('showAll')->with('error', 'Tidak dapat menghapus.');
        }
    }

    public function vieweditSkripsi(Request $request, $idskripsi) {
        $nip = $request->user()->dosen->nip;
        $dosens = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
            ->where('nip', $nip)
            ->select('dosen_wali.nama', 'dosen_wali.nip', 'users.id', 'users.username', 'users.foto')
            ->first();
        $skripsi = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
        ->join('mahasiswa','mahasiswa.nip','=','dosen_wali.nip')
        ->where('dosen_wali.nip',$nip)
        ->join('skripsi','skripsi.nim','=','mahasiswa.nim')
        ->where('skripsi.status','pending')
        ->where('skripsi.idskripsi',$idskripsi)
        ->select('skripsi.idskripsi','mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','skripsi.semester_aktif','skripsi.scanSkripsi','skripsi.nilai','skripsi.statusSkripsi','skripsi.lama_studi','skripsi.tanggal_sidang')
        ->first();
                
        return view('doswal.vieweditSkripsi', ['skripsi' => $skripsi,'dosens'=>$dosens]);
    }
    

    public function editSkripsi(Request $request, $idskripsi)
    {
        $skripsi = Skripsi::join('mahasiswa','skripsi.nim','=','mahasiswa.nim')
        ->where('skripsi.idskripsi',$idskripsi)
        ->where('skripsi.status','pending')
        ->select('skripsi.idskripsi','mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','skripsi.semester_aktif','skripsi.scanSkripsi','skripsi.nilai','skripsi.statusSkripsi','skripsi.lama_studi','skripsi.tanggal_sidang')
        ->first();

        $validated = $request->validate([
            'nilai' => [Rule::in(['A', 'B', 'C', 'D', 'E'])],
            'lama_studi'=>[Rule::in(['3', '4','5','6','7'])],
            'tanggal_sidang'=>['required'],
            'semester_aktif' => ['required', 'numeric'],
        ]);
        //dd($irs);
        // Jika IRS belum ada untuk nim dan semester yang ditentukan, maka inisialisasikan semester_aktif dengan 1

        // Melakukan validasi setelah menyesuaikan nilai semester_aktif
        $validated = $request->validate([
            'nilai' => [Rule::in(['A', 'B', 'C', 'D', 'E'])],
            'lama_studi'=>[Rule::in(['3', '4','5','6','7'])],
            'tanggal_sidang'=>['required'],
            'semester_aktif' => ['required', 'numeric'],
        ]);

        if ($skripsi) {
            $skripsi->nilai = $validated['nilai'];
            $skripsi->semester_aktif = $validated['semester_aktif'];
            $skripsi->lama_studi = $validated['lama_studi'];
            $skripsi->tanggal_sidang = $validated['tanggal_sidang'];
            $skripsi->save();

            return redirect()->route('showAll')->with('success', 'Skripsi berhasil diubah.');
        } else{
            return redirect()->route('showAll')->with('error', 'Terdapat error pada Skripsi');
        }
    }
    
}
