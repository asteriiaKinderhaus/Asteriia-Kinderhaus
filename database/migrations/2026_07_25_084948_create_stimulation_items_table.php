<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stimulation_items', function (Blueprint $table) {

            $table->char('id', 5)->primary();

            $table->char('category_id', 5);

            $table->string('name');

            $table->timestamps();

            $table->foreign('category_id')
                ->references('id')
                ->on('stimulation_categories')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stimulation_items');
    }
};
