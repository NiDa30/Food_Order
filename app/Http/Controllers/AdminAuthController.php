<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{    public function showLoginForm()
    {
        return view('admin.login');
    }    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Chỉ cho phép user có is_admin = 1
            if ($user->is_admin == 1) {
                return redirect()->route('admin.dashboard');
            }
            
            Auth::logout();
            return back()->withErrors([
                'email' => 'Bạn không có quyền truy cập trang admin.',
            ]);
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}
