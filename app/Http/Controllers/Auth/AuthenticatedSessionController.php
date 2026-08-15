<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        if (!$user->status) {

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'username' => 'Akun Anda telah dinonaktifkan. Silakan hubungi administrator.',
            ])->onlyInput('username');
        }
        $role = $user->role ?? null;

        if ((method_exists($user, 'isAdmin') && $user->isAdmin()) || $role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ((method_exists($user, 'isFacilitator') && $user->isFacilitator()) || $role === 'facilitator') {
            return redirect()->route('facilitator.dashboard');
        }

        if ((method_exists($user, 'isParent') && $user->isParent()) || $role === 'parent') {
            return redirect()->route('parent.dashboard');
        }

        Auth::logout();

        return redirect()->route('login')
            ->withErrors([
                'username' => 'Role pengguna tidak dikenali.',
            ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
