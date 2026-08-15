<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {

            $table->char('id', 10);

            $table->string('nis', 20)->unique();

            $table->string('name', 50);

            $table->string('nickname', 30)->nullable();

            $table->string('birth_place', 50)->nullable();

            $table->date('birth_date')->nullable();

            $table->char('gender_id', 1);

            $table->char('class_id', 10);

            $table->char('parent_id', 10);

            $table->string('photo')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->softDeletes();

            $table->primary('id');

            $table->foreign('gender_id')
                ->references('id')
                ->on('genders')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('class_id')
                ->references('id')
                ->on('school_classes')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('parent_id')
                ->references('id')
                ->on('parents')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
