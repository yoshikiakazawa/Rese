<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginAdminRequest;

class AuthAdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin/login');
    }

    public function login(LoginAdminRequest $request)
    {
        $credentials = $request->only(['login_admin_id', 'password']);

        if (Auth::guard('admins')->attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect()->route('admin');
        }
        return redirect()->back();

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('showLogin');
    }
}
