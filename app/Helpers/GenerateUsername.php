<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Str;

class GenerateUsername
{
    public static function make(string $name): string
    {
        // Generate Username Otomatis dari Nama
        $baseUsername = Str::slug($name, ''); // Menghapus spasi dan simbol
        $username = $baseUsername;

        // Hilangkan karakter aneh
        //$username = Str::ascii($name);

        // Huruf kecil
        //$username = Str::lower($username);

        // Ganti spasi menjadi titik
        //$username = preg_replace('/\s+/', '.', trim($username));

        // Hapus karakter selain huruf, angka, titik
        //$username = preg_replace('/[^a-z0-9.]/', '', $username);

        $original = $username;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $original . $counter;
            $counter++;
        }

        return $username;
    }
}
