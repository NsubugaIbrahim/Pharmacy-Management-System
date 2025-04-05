<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;

class LoginController extends Controller
{
    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            // Redirect based on user role
            //$this->authenticated($request, Auth::user());
            //  1. Check if the user is authenticated

            //return redirect()->intended('dashboard');
            $user = Auth::user();
        $role = $user->role->name ?? '';

        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'pharmacist':
                return redirect()->route('pharmacist.dashboard');
            case 'medical-assistant':
                return redirect()->route('medical-assistant.dashboard');
            case 'cashier':
                return redirect()->route('cashier.dashboard');
            case 'accountant':
                return redirect()->route('accountant.dashboard');
            default:
                return redirect()->route('home2');

        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
    // protected function authenticated(Request $request, $user)
    // {
    //     $roleName = $user->role->name ?? '';

    //     switch ($roleName) {
    //         case 'admin':
    //             return redirect()->route('admin.dashboard');
    //         case 'pharmacist':
    //             return redirect()->route('pharmacist.dashboard');
    //         case 'medical-assistant':
    //             return redirect()->route('medical-assistant.dashboard');
    //         case 'cashier':
    //             return redirect()->route('cashier.dashboard');
    //         case 'accountant':
    //             return redirect()->route('accountant.dashboard');
    //         default:
    //             return redirect()->route('home2');
    //     }
    // }
}
