<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_reports', function (Blueprint $table) {

            $table->char('id', 14);

            $table->date('report_date');

            $table->char('student_id', 10);

            $table->char('facilitator_id', 10);

            $table->char('class_id', 10);

            $table->text('additional_needs')->nullable();

            $table->longText('facilitator_activity')->nullable();
            $table->longText('parent_activity')->nullable();
            $table->longText('parent_note')->nullable();
            $table->boolean('status')->default(false);
            $table->primary('id');
            $table->unique(['student_id', 'report_date']);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('facilitator_id')
                ->references('id')
                ->on('facilitators')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('class_id')
                ->references('id')
                ->on('school_classes')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_reports');
    }
};
