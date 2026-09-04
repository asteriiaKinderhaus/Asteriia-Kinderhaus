<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facilitator_student', function (Blueprint $table) {
            $table->date('start_date')
                ->nullable()
                ->after('student_id');

            $table->date('end_date')
                ->nullable()
                ->after('start_date');
        });

        // Data hubungan yang sudah ada dianggap mulai aktif
        // pada tanggal 4 September 2026.
        DB::table('facilitator_student')
            ->whereNull('start_date')
            ->update([
                'start_date' => '2026-09-04',
            ]);

        // Setelah semua data lama mempunyai start_date,
        // ubah menjadi NOT NULL.
        Schema::table('facilitator_student', function (Blueprint $table) {
            $table->date('start_date')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('facilitator_student', function (Blueprint $table) {
            $table->dropColumn([
                'start_date',
                'end_date',
            ]);
        });
    }
};
