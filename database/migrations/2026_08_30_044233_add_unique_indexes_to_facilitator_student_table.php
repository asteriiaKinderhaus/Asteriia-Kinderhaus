<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facilitator_student', function (Blueprint $table) {
            $table->unique('facilitator_id', 'facilitator_student_facilitator_unique');
            $table->unique('student_id', 'facilitator_student_student_unique');
        });
    }

    public function down(): void
    {
        Schema::table('facilitator_student', function (Blueprint $table) {
            $table->dropUnique('facilitator_student_facilitator_unique');
            $table->dropUnique('facilitator_student_student_unique');
        });
    }
};