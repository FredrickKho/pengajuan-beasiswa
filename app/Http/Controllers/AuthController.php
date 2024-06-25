<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(){
        return view('layout.login');
    }
    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if($credentials){
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                $role = "";
                if (auth()->user()->role_id == 1) {
                    $role = "admin";
                } elseif (auth()->user()->role_id == 2) {
                    $role = "mahasiswa";
                } elseif (auth()->user()->role_id == 3) {
                    $role = "dekan";
                } else {
                    $role = "program-studi";
                }
                return redirect('/'.$role);
            } else {
                return redirect()->back()->with([
                    'status'=>'failed',
                    'message'=>'Incorrect username or password'
                ]);
            }
        }
        return redirect()->back();
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
