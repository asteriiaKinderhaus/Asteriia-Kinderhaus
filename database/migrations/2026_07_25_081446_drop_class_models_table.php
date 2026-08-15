<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Menghapus tabel dengan aman
        Schema::dropIfExists('class_models');
    }

    public function down(): void
    {
        // Opsional: Struktur buat ulang jika Anda melakukan rollback (opsional)
    }
};
