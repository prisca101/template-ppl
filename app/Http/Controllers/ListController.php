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
                                ->where('mahasiswa.angkatan', $angkatan)
                                ->where(function ($query) use ($status) {
                                    $query->where('pkl.status', $status);
                                })
                                ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'pkl.nilai', 'pkl.statusPKL', 'pkl.status')
                                ->get();
    
        return view('departemen.luluspkl', ['mahasiswas' => $mahasiswas->isEmpty() ? [] : $mahasiswas, 'departemen'=>$departemen]);
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
                ->where('mahasiswa.angkatan', $angkatan)
                ->where(function ($query) use ($status) {
                    $query->whereNull('pkl.nim')
                        ->orWhere(function ($query) use ($status) {
                            $query->where('pkl.status', '=', $status);
                        });
                })
                ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'pkl.nilai', 'pkl.status')
                ->get();
    
        return view('departemen.tidakluluspkl', ['mahasiswas' => $mahasiswas,'departemen'=>$departemen]);
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
        ->where('mahasiswa.angkatan', $angkatan)
        ->where(function ($query) use ($status) {
            $query->where('skripsi.status', $status);
        })
        ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'skripsi.nilai', 'skripsi.status','skripsi.tanggal_sidang','skripsi.lama_studi')
        ->get();
    
        return view('departemen.lulusskripsi', ['mahasiswas' => $mahasiswas, 'departemen'=>$departemen]);
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
                                ->where('mahasiswa.angkatan', $angkatan)
                                ->where(function ($query) use ($status) {
                                    $query->whereNull('skripsi.nim')
                                        ->orWhere(function ($query) use ($status) {
                                            $query->where('skripsi.status', '=', $status);
                                        });
                                })
                                ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'skripsi.nilai', 'skripsi.status')
                                ->get();

        return view('departemen.tidaklulusskripsi', ['mahasiswas' => $mahasiswas,'departemen'=>$departemen]);
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
        $pdf ->loadView('departemen.downloadlistlulusPKL',['mahasiswas'=>$mahasiswas, 'status'=>$status]);
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
        $pdf ->loadView('departemen.downloadlisttidaklulusPKL',['mahasiswas'=>$mahasiswas, 'status'=>$status]);
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
        $pdf ->loadView('departemen.downloadlistlulusSkripsi',['mahasiswas'=>$mahasiswas, 'status'=>$status]);
        return $pdf->stream('daftar-list-skripsi-lulus.pdf');
    }
    
    public function PreviewListSkripsiBelum(Request $request, $angkatan, $status){
    
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
                                ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'skripsi.nilai', 'skripsi.status', 'skripsi.tanggal_sidang','skripsi.lama_studi')
                                ->get();
        $pdf = app('dompdf.wrapper');
        $pdf ->loadView('departemen.downloadlisttidaklulusSkripsi',['mahasiswas'=>$mahasiswas, 'status'=>$status]);
        return $pdf->stream('daftar-list-skripsi-tidak-lulus.pdf');
    }

    public function listlulusPKL(Request $request, $angkatan, $status) {
        $nip = $request->user()->dosen->nip;
        $doswal = Dosen::leftJoin('users', 'dosen_wali.iduser', '=', 'users.id')
                ->where('dosen_wali.iduser', Auth::user()->id)
                ->select('dosen_wali.nama', 'dosen_wali.nip', 'users.username')
                ->first();
        $mahasiswas = Mahasiswa::leftJoin('pkl', function ($join) use ($status) {
                                    $join->on('mahasiswa.nim', '=', 'pkl.nim')
                                        ->where('pkl.status', '=', 'verified');
                                })
                                ->leftJoin('dosen_wali' , 'dosen_wali.nip','=','m.nip')
                                ->where('mahasiswa.angkatan', $angkatan)
                                ->where('dosen_wali.nip',$nip)
                                ->where(function ($query) use ($status) {
                                    $query->where('pkl.status', $status);
                                })
                                ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'pkl.nilai', 'pkl.statusPKL', 'pkl.status')
                                ->get();
    
        return view('doswal.luluspkl', ['mahasiswas' => $mahasiswas->isEmpty() ? [] : $mahasiswas, 'doswal'=>$doswal]);
    }    

    public function listidaklulusPKL(Request $request, $angkatan, $status) {
        $nip = $request->user()->dosen->nip;
        $doswal = Dosen::leftJoin('users', 'dosen_wali.iduser', '=', 'users.id')
                ->where('dosen_wali.iduser', Auth::user()->id)
                ->select('dosen_wali.nama', 'dosen_wali.nip', 'users.username')
                ->first();
        $mahasiswas = Mahasiswa::leftJoin('pkl', function ($join) use ($status) {
                    $join->on('mahasiswa.nim', '=', 'pkl.nim')
                        ->where('pkl.status', '=', 'verified');
                    })
                    ->leftJoin('dosen_wali' , 'dosen_wali.nip','=','m.nip')
                    ->where('mahasiswa.angkatan', $angkatan)
                    ->where('dosen_wali.nip',$nip)
                    ->where(function ($query) use ($status) {
                        $query->whereNull('pkl.nim')
                            ->orWhere(function ($query) use ($status) {
                                $query->where('pkl.status', '=', $status);
                            });
                    })
                    ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'pkl.nilai', 'pkl.status')
                    ->get();
    
        return view('doswal.tidakluluspkl', ['mahasiswas' => $mahasiswas->isEmpty() ? [] : $mahasiswas, 'doswal'=>$doswal]);
    }   
    
    public function lulusSkripsi(Request $request, $angkatan, $status){
        $nip = $request->user()->dosen->nip;
        $doswal = Dosen::leftJoin('users', 'dosen_wali.iduser', '=', 'users.id')
                ->where('dosen_wali.iduser', Auth::user()->id)
                ->select('dosen_wali.nama', 'dosen_wali.nip', 'users.username')
                ->first();
        $mahasiswas = Mahasiswa::leftJoin('skripsi', function ($join) use ($status) {
            $join->on('mahasiswa.nim', '=', 'skripsi.nim')
                ->where('skripsi.status', '=', 'verified');
        })
        ->leftJoin('dosen_wali' , 'dosen_wali.nip','=','m.nip')
        ->where('mahasiswa.angkatan', $angkatan)
        ->where('dosen_wali.nip',$nip)
        ->where(function ($query) use ($status) {
            $query->where('skripsi.status', $status);
        })
        ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'skripsi.nilai', 'skripsi.status','skripsi.tanggal_sidang','skripsi.lama_studi')
        ->get();
    
        return view('doswal.lulusSkripsi', ['mahasiswas' => $mahasiswas, 'doswal'=>$doswal]);
    }   

    public function tidaklulusSkripsi(Request $request, $angkatan, $status){
        $nip = $request->user()->dosen->nip;
        $doswal = Dosen::leftJoin('users', 'dosen_wali.iduser', '=', 'users.id')
                ->where('dosen_wali.iduser', Auth::user()->id)
                ->select('dosen_wali.nama', 'dosen_wali.nip', 'users.username')
                ->first();
        $mahasiswas = Mahasiswa::leftJoin('skripsi', function ($join) use ($status) {
                    $join->on('mahasiswa.nim', '=', 'skripsi.nim')
                        ->where('skripsi.status', '=', 'verified');
                    })
                    ->leftJoin('dosen_wali' , 'dosen_wali.nip','=','m.nip')
                    ->where('mahasiswa.angkatan', $angkatan)
                    ->where('dosen_wali.nip',$nip)
                    ->where(function ($query) use ($status) {
                        $query->whereNull('skripsi.nim')
                            ->orWhere(function ($query) use ($status) {
                                $query->where('skripsi.status', '=', $status);
                            });
                    })
                    ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'skripsi.nilai', 'skripsi.status')
                    ->get();
    
        return view('doswal.tidaklulusSkripsi', ['mahasiswas' => $mahasiswas, 'doswal'=>$doswal]);
    }   
}