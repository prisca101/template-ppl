<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash; 
use App\Models\Operator;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function login() {
        return view('login');
    }

    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha',
        ]);

        if ($credentials->fails()) {
            // Handle validation failure, e.g., redirect back with errors
            return redirect()->back()->with('error', 'Captcha salah');
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = $request->user(); 
        
            if ($user->role_id === 1 ) {
                if($user->cekProfil === 1){
                    return redirect()->intended('/dashboardMahasiswa')->with('success', 'Login successful');
                }
                return redirect()->route('mhs.edit2')->with('error','Harap lengkapi data profil anda');
            } else if ($user->role_id === 2) {
                return redirect()->intended('/dashboardDosen')->with('success', 'Login successful');
            } else if ($user->role_id === 3) {
                return redirect()->intended('/dashboardOperator')->with('success', 'Login successful');
            } else if ($user->role_id === 4) {
                return redirect()->intended('/dashboardDepartemen')->with('success', 'Login successful');
            }
            
        };

        return back()->with('error', 'Login Gagal');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return view('login');
    }

}
