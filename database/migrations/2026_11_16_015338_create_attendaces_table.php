
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->char('id', 10)->primary();

            $table->char('student_id', 10);
            $table->char('facilitator_id', 10);

            $table->date('attendance_date');

            $table->enum('status', [
                'H',
                'S',
                'I',
                'A'
            ]);

            $table->text('notes')->nullable();

            $table->timestamps();

            // Satu peserta didik hanya boleh
            // memiliki satu absensi per tanggal.
            $table->unique(
                ['student_id', 'attendance_date'],
                'attendance_student_date_unique'
            );

            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onDelete('restrict');

            $table->foreign('facilitator_id')
                ->references('id')
                ->on('facilitators')
                ->onDelete('restrict');

            $table->index('attendance_date');
            $table->index('facilitator_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
