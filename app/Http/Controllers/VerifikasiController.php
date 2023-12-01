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
        return view('doswal.verification', ['irs'=>$irs,'khs'=>$khs,'pkl'=>$pkl,'skripsi'=>$skripsi]);
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

    public function rejected($nim,$semester_aktif){
        $irs = IRS::where('nim', $nim)
                ->where('semester_aktif', $semester_aktif)
                ->first();
    
        if ($irs) {
            IRS::where('nim', $irs->nim)
            ->where('semester_aktif', $semester_aktif)
            ->update(['status' => 'rejected']);
            return redirect()->route('showAll')->with('success', 'IRS berhasil ditolak.');
        }
        else {
            return redirect()->route('showAll')->with('error', 'Tidak dapat menolak.');
        }
    }

    public function vieweditIRS($idirs){
        // $irs = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
        //         ->join('mahasiswa','mahasiswa.nip','=','dosen_wali.nip')
        //         ->where('mahasiswa.nim', $nim)
        //         ->where('irs.semester_aktif', $semester_aktif)
        //         ->join('irs','irs.nim','=','mahasiswa.nim')
        //         ->where('irs.status','pending')
        //         ->select('mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','irs.semester_aktif','irs.jumlah_sks','irs.scanIRS')
        //         ->get();

        $irs = IRS::join('mahasiswa','irs.nim','=','mahasiswa.nim')
                ->where('irs.idirs', $idirs)
                ->where('irs.status','pending')
                ->select('irs.idirs','mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','irs.semester_aktif','irs.jumlah_sks','irs.scanIRS')
                ->first();

        return view('doswal.vieweditIRS',['irs'=>$irs]);
    }

    public function editIRS(Request $request,$idirs)
    {
        // Mendapatkan IRS berdasarkan nim dan semester aktif
        $irs = IRS::where('idirs', $idirs)
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



    public function verifikasiKHS($nim, $semester_aktif)
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

    public function rejectedKHS($nim,$semester_aktif){
        $khs = KHS::where('nim', $nim)
                ->where('semester_aktif', $semester_aktif)
                ->first();

        if($khs){
            KHS::where('nim', $khs->nim)
            ->where('semester_aktif', $semester_aktif)
            ->update(['status' => 'rejected']);
            return redirect()->route('showAll')->with('success', 'KHS berhasil ditolak.');
        }
        else {
            return redirect()->route('showAll')->with('error', 'Tidak dapat menolak.');
        }
    }

    public function vieweditKHS($idkhs){
        // $khs = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
        //         ->join('mahasiswa','mahasiswa.nip','=','dosen_wali.nip')
        //         ->where('mahasiswa.nim', $nim)
        //         ->where('khs.semester_aktif', $semester_aktif)
        //         ->join('khs','khs.nim','=','mahasiswa.nim')
        //         ->where('khs.status','pending')
        //         ->select('mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','khs.semester_aktif','khs.jumlah_sks','khs.scanKHS','khs.jumlah_sks_kumulatif','khs.ip_semester','khs.ip_kumulatif')
        //         ->get();
        $khs = KHS::join('mahasiswa','khs.nim','=','mahasiswa.nim')
                ->where('khs.idkhs', $idkhs)
                ->where('khs.status','pending')
                ->select('khs.idkhs','mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','khs.semester_aktif','khs.jumlah_sks','khs.scanKHS','khs.jumlah_sks_kumulatif','khs.ip_semester','khs.ip_kumulatif')
                ->first();


        return view('doswal.vieweditKHS',['khs'=>$khs]);
    }

    public function editKHS(Request $request, $idkhs)
    {
        // Mendapatkan IRS berdasarkan nim dan semester aktif
        $khs = KHS::where('idkhs', $idkhs)
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

    public function verifikasiPKL($nim, $semester_aktif)
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

    public function rejectedPKL($nim,$semester_aktif){
        $pkl = PKL::where('nim', $nim)
                ->where('semester_aktif', $semester_aktif)
                ->first();

        if($pkl){
            PKL::where('nim', $pkl->nim)
            ->where('semester_aktif', $semester_aktif)
            ->update(['status' => 'rejected']);
            return redirect()->route('showAll')->with('success', 'PKL berhasil ditolak.');
        }
        else {
            return redirect()->route('showAll')->with('error', 'Tidak dapat menolak.');
        }
    }

    public function vieweditPKL($idpkl){
        // $pkl = Dosen::join('users', 'dosen_wali.iduser', '=', 'users.id')
        //         ->join('mahasiswa','mahasiswa.nip','=','dosen_wali.nip')
        //         ->where('mahasiswa.nim', $nim)
        //         ->where('pkl.semester_aktif', $semester_aktif)
        //         ->join('pkl','pkl.nim','=','mahasiswa.nim')
        //         ->where('pkl.status','pending')
        //         ->select('mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','pkl.semester_aktif','pkl.nilai','pkl.scanPKL')
        //         ->get();

        $pkl = PKL::join('mahasiswa','pkl.nim','=','mahasiswa.nim')
                ->where('pkl.idpkl', $idpkl)
                ->where('pkl.status','pending')
                ->select('pkl.idpkl','mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','pkl.semester_aktif','pkl.nilai','pkl.scanPKL')
                ->first();

        return view('doswal.vieweditPKL',['pkl'=>$pkl]);
    }

    public function editPKL(Request $request, $idpkl)
    {
        // Mendapatkan IRS berdasarkan nim dan semester aktif
        $pkl = PKL::where('idpkl', $idpkl)
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
    
    public function verifikasiSkripsi($nim, $semester_aktif)
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

    public function rejectedSkripsi($nim,$semester_aktif){
        $skripsi = Skripsi::where('nim', $nim)
                ->where('semester_aktif', $semester_aktif)
                ->first();

        if($skripsi){
            Skripsi::where('nim', $skripsi->nim)
            ->where('semester_aktif', $semester_aktif)
            ->update(['status' => 'rejected']);
            return redirect()->route('showAll')->with('success', 'Skripsi berhasil ditolak.');
        }
        else {
            return redirect()->route('showAll')->with('error', 'Tidak dapat menolak.');
        }
    }

    public function vieweditSkripsi($idskripsi) {
        // $skripsi = Skripsi::join('mahasiswa', 'skripsi.nim', '=', 'mahasiswa.nim')
        //             ->where('mahasiswa.nim', $nim)
        //             ->where('skripsi.semester_aktif', $semester_aktif)
        //             ->where('skripsi.status', 'pending')
        //             ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'skripsi.semester_aktif', 'skripsi.nilai', 'skripsi.scanSkripsi', 'skripsi.tanggal_sidang', 'skripsi.lama_studi')
        //             ->first();
        $skripsi = Skripsi::join('mahasiswa','skripsi.nim','=','mahasiswa.nim')
                ->where('skripsi.idskripsi', $idskripsi)
                ->where('skripsi.status','pending')
                ->select('skripsi.idskripsi','mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'skripsi.semester_aktif', 'skripsi.nilai', 'skripsi.scanSkripsi', 'skripsi.tanggal_sidang', 'skripsi.lama_studi');
                
        return view('doswal.vieweditSkripsi', ['skripsi' => $skripsi]);
    }
    

    public function editSkripsi(Request $request, $idskripsi)
    {
        // Mendapatkan IRS berdasarkan nim dan semester aktif
        $skripsi = Skripsi::where('idskripsi', $idskripsi);

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
