<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facilitator_class', function (Blueprint $table) {

            $table->string('id', 10)->primary();

            $table->string('facilitator_id', 10);

            $table->string('class_id', 10);

            $table->timestamps();

            $table->foreign('facilitator_id')
                ->references('id')
                ->on('facilitators')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('class_id')
                ->references('id')
                ->on('school_classes')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unique([
                'facilitator_id',
                'class_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facilitator_class');
    }
};
