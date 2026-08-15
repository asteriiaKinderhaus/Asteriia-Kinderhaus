<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daily_report_stimulations', function (Blueprint $table) {

            // hapus foreign key
            $table->dropForeign([
                'daily_report_id'
            ]);
        });

        Schema::table('daily_report_stimulations', function (Blueprint $table) {

            $table->char('daily_report_id', 14)->change();
        });

        Schema::table('daily_report_stimulations', function (Blueprint $table) {

            $table->foreign('daily_report_id')
                ->references('id')
                ->on('daily_reports')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('daily_report_stimulations', function (Blueprint $table) {

            $table->dropForeign([
                'daily_report_id'
            ]);
        });

        Schema::table('daily_report_stimulations', function (Blueprint $table) {

            $table->char('daily_report_id', 10)->change();
        });

        Schema::table('daily_report_stimulations', function (Blueprint $table) {

            $table->foreign('daily_report_id')
                ->references('id')
                ->on('daily_reports')
                ->cascadeOnDelete();
        });
    }
};
