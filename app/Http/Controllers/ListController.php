<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Departemen;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;

class ListController extends Controller
{
    public function index(Request $request, $angkatan, $status) {
        $departemen = Departemen::leftJoin('users', 'departemen.iduser', '=', 'users.id')
                ->where('departemen.iduser', Auth::user()->id)
                ->select('departemen.nama', 'departemen.kode', 'users.username')
                ->first();
        $mahasiswas = Mahasiswa::leftJoin('pkl', function ($join) use ($status) {
                    $join->on('mahasiswa.nim', '=', 'pkl.nim')
                        ->where('pkl.status', '=', 'verified');
                })
                ->join('dosen_wali','dosen_wali.nip','=','mahasiswa.nip')
                ->where('mahasiswa.angkatan', $angkatan)
                ->where(function ($query) use ($status) {
                    $query->where('pkl.status', $status);
                })
                ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'pkl.nilai', 'pkl.statusPKL', 'pkl.status','pkl.scanPKL','dosen_wali.nama as dosen_nama')
                ->get();
    
        return view('departemen.luluspkl', ['mahasiswas' => $mahasiswas->isEmpty() ? [] : $mahasiswas, 'departemen'=>$departemen,'angkatan'=>$angkatan,'status'=>$status]);
    }    

    public function index2(Request $request, $angkatan, $status) {
        $departemen = Departemen::leftJoin('users', 'departemen.iduser', '=', 'users.id')
                ->where('departemen.iduser', Auth::user()->id)
                ->select('departemen.nama', 'departemen.kode', 'users.username')
                ->first();
        $mahasiswas = Mahasiswa::leftJoin('pkl', function ($join) use ($status) {
                    $join->on('mahasiswa.nim', '=', 'pkl.nim')
                        ->where('pkl.status', '=', 'verified');
                    })
                    ->join('dosen_wali','dosen_wali.nip','=','mahasiswa.nip')
                    ->where('mahasiswa.angkatan', $angkatan)
                    ->where(function ($query) use ($status) {
                        $query->whereNull('pkl.nim')
                            ->orWhere(function ($query) use ($status) {
                                $query->where('pkl.status', '=', $status);
                            });
                    })
                    ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'pkl.nilai', 'pkl.status','pkl.scanPKL','dosen_wali.nama as dosen_nama')
                    ->get();
    
        return view('departemen.tidakluluspkl', ['mahasiswas' => $mahasiswas,'departemen'=>$departemen,'angkatan'=>$angkatan,'status'=>$status]);
    }    

    public function skripsi(Request $request, $angkatan, $status){
        $departemen = Departemen::leftJoin('users', 'departemen.iduser', '=', 'users.id')
                ->where('departemen.iduser', Auth::user()->id)
                ->select('departemen.nama', 'departemen.kode', 'users.username')
                ->first();
        $mahasiswas = Mahasiswa::leftJoin('skripsi', function ($join) use ($status) {
                    $join->on('mahasiswa.nim', '=', 'skripsi.nim')
                        ->where('skripsi.status', '=', 'verified');
                    })
                    ->join('dosen_wali','dosen_wali.nip','=','mahasiswa.nip')
                    ->where('mahasiswa.angkatan', $angkatan)
                    ->where(function ($query) use ($status) {
                        $query->where('skripsi.status', $status);
                    })
                    ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'skripsi.nilai', 'skripsi.status','skripsi.tanggal_sidang','skripsi.lama_studi','skripsi.scanSkripsi','dosen_wali.nama as dosen_nama')
                    ->get();

        return view('departemen.lulusskripsi', ['mahasiswas' => $mahasiswas, 'departemen'=>$departemen,'angkatan'=>$angkatan,'status'=>$status]);
    }    

    public function skripsi2(Request $request, $angkatan, $status){
        $departemen = Departemen::leftJoin('users', 'departemen.iduser', '=', 'users.id')
                ->where('departemen.iduser', Auth::user()->id)
                ->select('departemen.nama', 'departemen.kode', 'users.username')
                ->first();

        
        $mahasiswas = Mahasiswa::leftJoin('skripsi', function ($join) use ($status) {
                    $join->on('mahasiswa.nim', '=', 'skripsi.nim')
                        ->where('skripsi.status', '=', 'verified');
                    })
                    ->join('dosen_wali','dosen_wali.nip','=','mahasiswa.nip')
                    ->where('mahasiswa.angkatan', $angkatan)
                    ->where(function ($query) use ($status) {
                        $query->whereNull('skripsi.nim')
                            ->orWhere(function ($query) use ($status) {
                                $query->where('skripsi.status', '=', $status);
                            });
                    })
                    ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'skripsi.nilai', 'skripsi.status', 'skripsi.tanggal_sidang','skripsi.lama_studi','dosen_wali.nama as dosen_nama')
                    ->get();
        return view('departemen.tidaklulusskripsi', ['mahasiswas' => $mahasiswas,'departemen'=>$departemen,'angkatan'=>$angkatan,'status'=>$status]);
    }
    
    public function PreviewListPKLLulus(Request $request, $angkatan, $status) {
        $mahasiswas = Mahasiswa::leftJoin('pkl', function ($join) use ($status) {
                                $join->on('mahasiswa.nim', '=', 'pkl.nim')
                                    ->where('pkl.status', '=', 'verified');
                            })
                            ->where('mahasiswa.angkatan', $angkatan)
                            ->where(function ($query) use ($status) {
                                $query->where('pkl.status', $status);
                            })
                            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'pkl.nilai', 'pkl.statusPKL', 'pkl.status')
                            ->get();
        $pdf = app('dompdf.wrapper');
        $pdf ->loadView('departemen.downloadlistlulusPKL',['mahasiswas'=>$mahasiswas, 'angkatan'=>$angkatan,'status'=>$status]);
        return $pdf->stream('daftar-list-pkl-lulus.pdf');
    
        if ($mahasiswas->isEmpty()) {
            // Lakukan penanganan jika $mahasiswas kosong, seperti menampilkan pesan atau mengarahkan ke halaman lain
            return redirect()->back()->with('error', 'Tidak ada data yang tersedia.');
        }
    }
    
    public function PreviewListPKLBelum(Request $request, $angkatan, $status){
    
        $mahasiswas = Mahasiswa::leftJoin('pkl', function ($join) use ($status) {
                                $join->on('mahasiswa.nim', '=', 'pkl.nim')
                                    ->where('pkl.status', '=', 'verified');
                                })
                                ->where('mahasiswa.angkatan', $angkatan)
                                ->where(function ($query) use ($status) {
                                    $query->whereNull('pkl.nim')
                                        ->orWhere(function ($query) use ($status) {
                                            $query->where('pkl.status', '=', $status);
                                        });
                                })
                                ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'pkl.nilai', 'pkl.status')
                                ->get();
        $pdf = app('dompdf.wrapper');
        $pdf ->loadView('departemen.downloadlisttidaklulusPKL',['mahasiswas'=>$mahasiswas,'angkatan'=>$angkatan,'status'=>$status]);
        return $pdf->stream('daftar-list-pkl-tidak-lulus.pdf');
    }

    public function PreviewListSkripsiLulus(Request $request, $angkatan, $status) {
        $mahasiswas = Mahasiswa::leftJoin('skripsi', function ($join) use ($status) {
                                $join->on('mahasiswa.nim', '=', 'skripsi.nim')
                                    ->where('skripsi.status', '=', 'verified');
                            })
                            ->where('mahasiswa.angkatan', $angkatan)
                            ->where(function ($query) use ($status) {
                                $query->where('skripsi.status', $status);
                            })
                            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'skripsi.nilai', 'skripsi.statusSkripsi', 'skripsi.status','skripsi.tanggal_sidang','skripsi.lama_studi')
                            ->get();
    
        if ($mahasiswas->isEmpty()) {
            // Lakukan penanganan jika $mahasiswas kosong, seperti menampilkan pesan atau mengarahkan ke halaman lain
            return redirect()->back()->with('error', 'Tidak ada data yang tersedia.');
        }

        $pdf = app('dompdf.wrapper');
        $pdf ->loadView('departemen.downloadlistlulusSkripsi',['mahasiswas'=>$mahasiswas,'angkatan'=>$angkatan,'status'=>$status]);
        return $pdf->stream('daftar-list-skripsi-lulus.pdf');
    }
    
    public function PreviewListSkripsiBelum(Request $request, $angkatan, $status) {
        $mahasiswas = Mahasiswa::leftJoin('skripsi', function ($join) use ($status) {
                                $join->on('mahasiswa.nim', '=', 'skripsi.nim')
                                    ->where('skripsi.status', '=', 'verified');
                            })
                            ->where('mahasiswa.angkatan', $angkatan)
                            ->where(function ($query) use ($status) {
                                $query->whereNull('skripsi.nim')
                                    ->orWhere(function ($query) use ($status) {
                                        $query->where('skripsi.status', '=', $status);
                                    });
                            })
                            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'skripsi.nilai', 'skripsi.statusSkripsi', 'skripsi.status','skripsi.tanggal_sidang','skripsi.lama_studi')
                            ->get();
    
        if ($mahasiswas->isEmpty()) {
            // Lakukan penanganan jika $mahasiswas kosong, seperti menampilkan pesan atau mengarahkan ke halaman lain
            return redirect()->back()->with('error', 'Tidak ada data yang tersedia.');
        }

        $pdf = app('dompdf.wrapper');
        $pdf ->loadView('departemen.downloadlisttidaklulusSkripsi',['mahasiswas'=>$mahasiswas,'angkatan'=>$angkatan,'status'=>$status]);
        return $pdf->stream('daftar-list-skripsi-belum-lulus.pdf');
    }

    public function daftarstatus($angkatan, $status){
        $departemen = Departemen::leftJoin('users', 'departemen.iduser', '=', 'users.id')
                ->where('departemen.iduser', Auth::user()->id)
                ->select('departemen.nama', 'departemen.kode', 'users.username')
                ->first();
        $daftar = Mahasiswa::join('dosen_wali','dosen_wali.nip','=','mahasiswa.nip')
                ->select('mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','mahasiswa.status','dosen_wali.nama as dosen_nama')
                ->where('mahasiswa.angkatan',$angkatan)
                ->where('mahasiswa.status',$status)
                ->get();

        $namastatus = [
            'active' => 'Aktif',
            'lulus' => 'Lulus',
            'meninggal_dunia' => 'Meninggal Dunia',
            'do' => 'Drop Out',
            'cuti' => 'Cuti',
            'undur_diri' => 'Undur Diri',
            'mangkir' => 'Mangkir'
        ];

        $status_label = isset($namastatus[$status]) ? $namastatus[$status] : $status;

        return view('departemen.daftarstatus',['daftar'=>$daftar,'departemen'=>$departemen,'namastatus'=>$status_label,'angkatan'=>$angkatan,'status'=>$status]);
    }

    public function PreviewListStatus(Request $request, $angkatan, $status){
    
        $departemen = Departemen::leftJoin('users', 'departemen.iduser', '=', 'users.id')
                ->where('departemen.iduser', Auth::user()->id)
                ->select('departemen.nama', 'departemen.kode', 'users.username')
                ->first();
        $daftar = Mahasiswa::join('dosen_wali','dosen_wali.nip','=','mahasiswa.nip')
                            ->select('mahasiswa.nama','mahasiswa.nim','mahasiswa.angkatan','mahasiswa.status','dosen_wali.nama as dosen_nama')
                            ->where('mahasiswa.angkatan',$angkatan)
                            ->where('mahasiswa.status',$status)
                            ->get();

        $namastatus = [
            'active' => 'Aktif',
            'lulus' => 'Lulus',
            'meninggal_dunia' => 'Meninggal Dunia',
            'do' => 'Drop Out',
            'cuti' => 'Cuti',
            'undur_diri' => 'Undur Diri',
            'mangkir' => 'Mangkir'
        ];

        $status_label = isset($namastatus[$status]) ? $namastatus[$status] : $status;
        $pdf = app('dompdf.wrapper');
        $pdf ->loadView('departemen.downloadStatus',['daftar'=>$daftar, 'namastatus'=>$status_label,'departemen'=>$departemen,'angkatan'=>$angkatan,'status'=>$status]);
        return $pdf->stream('daftar-list-status.pdf');
    }
   
}