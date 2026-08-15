<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_report_stimulations', function (Blueprint $table) {

            $table->char('id', 10)->primary();

            $table->char('daily_report_id', 10);

            $table->char('stimulation_item_id', 5);

            $table->timestamps();

            $table->foreign('daily_report_id')
                ->references('id')
                ->on('daily_reports')
                ->cascadeOnDelete();

            $table->foreign('stimulation_item_id')
                ->references('id')
                ->on('stimulation_items')
                ->cascadeOnDelete();

            // agar satu item tidak bisa dipilih dua kali
            $table->unique([
                'daily_report_id',
                'stimulation_item_id'
            ], 'daily_report_stimulation_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_report_stimulations');
    }
};
