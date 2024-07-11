<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginOwnerRequest;

class AuthOwnerController extends Controller
{
    public function showLoginForm()
    {
        return view('owner/login');
    }

    public function login(LoginOwnerRequest $request)
    {
        $credentials = $request->only(['ownerid', 'password']);

        if (Auth::guard('owners')->attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect()->route('owner');
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
