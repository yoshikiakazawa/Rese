<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminRequest;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin/login');
    }

    public function login(AdminRequest $request)
    {
        $credentials = $request->only(['adminid', 'password']);

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

        return redirect()->route('showLoginForm');
    }

    public function admin() {

        return view('admin.index');
    }
}
