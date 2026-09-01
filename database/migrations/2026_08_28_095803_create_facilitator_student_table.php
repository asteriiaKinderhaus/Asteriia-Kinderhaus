<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facilitator_student', function (Blueprint $table) {

            $table->char('facilitator_id', 10);
            $table->char('student_id', 10);

            $table->timestamps();

            $table->primary([
                'facilitator_id',
                'student_id'
            ]);

            $table->foreign('facilitator_id')
                ->references('id')
                ->on('facilitators')
                ->cascadeOnDelete();

            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facilitator_student');
    }
};