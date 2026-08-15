<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordResetMail;
use App\Models\Facilitator;
use App\Models\ParentModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    /**
     * Menampilkan form lupa password.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Mengirim link reset password ke email user.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => [
                'required',
                'email',
            ],
        ]);

        $email = $request->email;

        /*
        |--------------------------------------------------------------------------
        | Cari berdasarkan email Facilitator
        |--------------------------------------------------------------------------
        */

        $facilitator = Facilitator::where('email', $email)
            ->first();

        if ($facilitator) {

            $user = $facilitator->user;

            if (!$user) {
                return back()
                    ->withErrors([
                        'email' => 'Akun pengguna tidak ditemukan.',
                    ])
                    ->withInput();
            }

            return $this->sendResetLink(
                $user,
                $facilitator->name,
                $email
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Cari berdasarkan email Parent
        |--------------------------------------------------------------------------
        */

        $parent = ParentModel::where('email', $email)
            ->first();

        if ($parent) {

            $user = $parent->user;

            if (!$user) {
                return back()
                    ->withErrors([
                        'email' => 'Akun pengguna tidak ditemukan.',
                    ])
                    ->withInput();
            }

            return $this->sendResetLink(
                $user,
                $parent->name,
                $email
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Email tidak ditemukan
        |--------------------------------------------------------------------------
        */

        return back()
            ->withErrors([
                'email' => 'Email tidak terdaftar.',
            ])
            ->withInput();
    }

    /**
     * Membuat token dan mengirim email reset password.
     */
    private function sendResetLink(
        $user,
        string $name,
        string $email
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Buat token
        |--------------------------------------------------------------------------
        */

        $token = Str::random(64);

        /*
        |--------------------------------------------------------------------------
        | Simpan hash token ke users
        |--------------------------------------------------------------------------
        */

        $user->update([
            // 'reset_password_token' => hash('sha256', $token),
            'reset_password_token' =>  $token,
            'reset_password_expires_at' => now()->addMinutes(60),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Buat URL reset password
        |--------------------------------------------------------------------------
        */

        $resetUrl = route('password.reset', [
            'token' => $token,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Kirim email
        |--------------------------------------------------------------------------
        */

        Mail::to($email)->send(
            new PasswordResetMail(
                $name,
                $resetUrl,
                60
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Kembali ke form forgot password
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'status',
            'Link reset password telah dikirim ke email Anda.'
        );
    }
}
