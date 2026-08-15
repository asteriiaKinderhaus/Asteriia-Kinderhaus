<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /**
     * Tampilkan form reset password
     */
    public function create(string $token)
    {
        $user = User::where('reset_password_token', $token)
            ->where('reset_password_expires_at', '>', now())
            ->first();
        //dd($user);
        if (!$user) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Link reset password tidak valid atau sudah kedaluwarsa.'
                ]);
        }

        $resetUrl = route('password.store');

        return view('auth.reset-password', [
            'token'    => $token,
            'resetUrl' => $resetUrl,
        ]);
    }

    /**
     * Proses password baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('reset_password_token', $request->token)
            ->where('reset_password_expires_at', '>', now())
            ->first();

        if (!$user) {
            return back()->withErrors([
                'token' => 'Link reset password tidak valid atau sudah kedaluwarsa.'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'reset_password_token' => null,
            'reset_password_expires_at' => null,
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Password berhasil diubah. Silakan login dengan password baru.');
    }
}
