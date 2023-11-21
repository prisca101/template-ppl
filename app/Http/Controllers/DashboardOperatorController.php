<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Departemen;
use App\Models\Operator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class DashboardOperatorController extends Controller
{      
        public function dashboardOperator(Request $request) {
                if (Auth::check() && Auth::user()->role_id === 3) {
                    $operators = Operator::leftJoin('users', 'operator.iduser', '=', 'users.id')
                        ->where('operator.iduser', Auth::user()->id)
                        ->select('operator.nama', 'operator.nip', 'users.username')
                        ->first();
            
                    if ($operators) {
                        $mahasiswaCount = Mahasiswa::count();
                        $dosenCount = Dosen::count();
                        $departemenCount = Departemen::count();
                        $userCount = User::count();
                        
                        $users = User::join('roles', 'users.role_id', '=', 'roles.id')
                            ->select('users.role_id', 'roles.name')
                            ->get();
                        
                        $user = User::where('id', Auth::user()->id)->select('foto')->first();
                        
                        return view('operator.dashboard', [
                            'operators' => $operators,
                            'users' => $users,
                            'user_count' => $userCount,
                            'mahasiswa_count' => $mahasiswaCount,
                            'dosen_count' => $dosenCount,
                            'departemen_count' => $departemenCount,
                        ]);
                    }
                }
            
                // Jika kondisi tidak memenuhi atau pengguna bukan operator dengan role_id 3, kembalikan respons yang sesuai
                return redirect()->route('home')->with('error', 'Unauthorized access!');
            }
        
        public function mahasiswa(){
                dd("aa");
                $mahasiswas = Mahasiswa::join('users', 'mahasiswa.iduser', '=', 'users.id')
                            ->join('dosen_wali', 'mahasiswa.nip', '=', 'dosen_wali.nip')
                            ->join('generate_akun', 'generate_akun.nim', '=', 'mahasiswa.nim')
                            ->select('mahasiswa.nama', 'mahasiswa.nim', 'mahasiswa.angkatan', 'mahasiswa.status', 'users.username', 'generate_akun.password', 'dosen_wali.nip', 'dosen_wali.nama as dosen_nama', 'mahasiswa.jalur_masuk')
                            ->get();
                return view('operator.mahasiswa', ['mahasiswas' => $mahasiswas,]);
        }
            
}    
    
