<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('app.login');
    }

    public function handleLogin(Request $request)
    {
        $request->validate([
            'callsign' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $credentials = $request->only('callsign', 'password');
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            }
            return back()->withErrors([
                'callsign' => 'The provided credentials do not match our records.',
            ])->onlyInput('callsign')->with([
                'status' => 'error',
                'message' => 'Login failed. Please check your callsign and password.',
            ]);
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'An error occurred during login. Please try again later.',
            ])->onlyInput('callsign')->with([
                'status' => 'error',
                'message' => 'An unexpected error occurred. Please try again later.',
            ]);
        }
    }

    public function registerPage()
    {
        return view('app.register');
    }

    public function handleRegister(Request $request)
    {
        $request->validate([
            'callsign' => 'required|string|unique:users,callsign',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:6',
            'phone' => 'nullable|string',
        ]);

        try {
            $user = new \App\Models\User();
            $user->callsign = $request->callsign;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = bcrypt($request->password);
            $user->role = 'guest';
            $user->save();

            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        } catch (\Throwable $e) {
            dd($e->getMessage());
            return back()->withErrors([
                'error' => 'An error occurred during registration. Please try again later.',
            ])->onlyInput('callsign', 'email', 'phone', 'name')->with([
                'status' => 'error',
                'message' => 'An unexpected error occurred. Please try again later.',
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('welcome');
    }
}
