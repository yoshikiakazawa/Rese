<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verification_token' => Str::random(60),
        ]);

        $user->notify(new EmailVerificationNotification($user->email_verification_token));
        Auth::login($user);

        return redirect()->route('thanks');
    }

    public function verifyEmail($token)
    {
        $user = User::where('email_verification_token', $token)->firstOrFail();
        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->save();

        Auth::login($user);

        return redirect()->route('index')->with('success', 'Your email has been verified!');
    }

    public function thanks()
    {
        return view('auth.thanks');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::guard('web')->attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect()->route('index');
        }
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("login");
    }

}
