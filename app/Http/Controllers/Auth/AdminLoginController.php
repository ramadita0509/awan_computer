<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminLoginController extends Controller
{
    /**
     * Display the admin login view.
     */
    public function create(): View
    {
        return view('auth.admin-login');
    }

    /**
     * Handle an incoming admin authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        // Check if user is admin or super admin
        if (!$user->canAccessBackend()) {
            Auth::logout();
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Akun ini tidak memiliki akses admin. Silakan login sebagai customer.',
            ]);
        }

        // Redirect to dashboard
        return redirect()->intended(route('dashboard', absolute: false));
    }
}

