<?php

namespace App\Services;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Helpers\GenerateId;

class AccountService
{
    /**
     * Generate username berdasarkan nama.
     */
    public function generateUsername(string $name): string
    {
        $base = Str::slug($name, '');

        if ($base == '') {
            $base = 'user';
        }

        $username = strtolower($base);
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = strtolower($base) . $counter;
            $counter++;
        }

        return $username;
    }

    /**
     * Generate password acak.
     */
    public function generatePassword(int $length = 8): string
    {
        return Str::random($length);
    }

    /**
     * Membuat akun user.
     */
    public function createUser(string $name, string $roleId): array
    {
        $username = $this->generateUsername($name);
        $password = $this->generatePassword();

        $user = User::create([
            'id'       => GenerateId::make(User::class, 'USR'),
            'username' => $username,
            'password' => Hash::make($password),
            'role_id'  => $roleId,
            'status'   => true,
        ]);

        return [
            'user' => $user,
            'username' => $username,
            'password' => $password,
        ];
    }

    /**
     * Reset password.
     */
    public function resetPassword(User $user): string
    {
        $password = $this->generatePassword();

        $user->update([
            'password' => Hash::make($password),
        ]);

        return $password;
    }
}
